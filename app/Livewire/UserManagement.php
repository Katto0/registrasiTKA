<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class UserManagement extends Component
{
    use WithPagination;

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    public $editingId = null;
    public $successMessage = '';
    public $showForm = false;

    public function render()
    {
        $users = User::query()->latest()->paginate(10);
        return view('livewire.user-management', ['users' => $users]);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        $this->form['name'] = $user->name;
        $this->form['email'] = $user->email;
        $this->form['password'] = '';
        $this->editingId = $user->id;
        $this->showForm = true;
    }

    public function save()
    {
        if ($this->editingId) {
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    public function createUser()
    {
        $messages = [
            'form.name.required' => 'Nama wajib diisi.',
            'form.name.min' => 'Nama minimal terdiri dari :min karakter.',
            'form.email.required' => 'Email wajib diisi.',
            'form.email.email' => 'Format email tidak valid.',
            'form.email.unique' => 'Email sudah terdaftar.',
            'form.password.required' => 'Kata sandi wajib diisi.',
            'form.password.min' => 'Kata sandi minimal :min karakter.',
        ];

        $validated = $this->validate([
            'form.name' => 'required|min:3',
            'form.email' => 'required|email|unique:users,email',
            'form.password' => 'required|min:8',
        ], $messages);

        User::create([
            'name' => $validated['form']['name'],
            'email' => $validated['form']['email'],
            'password' => $validated['form']['password'],
        ]);

        $this->resetForm();
        $this->successMessage = 'Pengguna berhasil ditambahkan.';
        $this->showForm = false;
        $this->resetPage();
    }

    public function updateUser()
    {
        $messages = [
            'form.name.required' => 'Nama wajib diisi.',
            'form.name.min' => 'Nama minimal terdiri dari :min karakter.',
            'form.email.required' => 'Email wajib diisi.',
            'form.email.email' => 'Format email tidak valid.',
            'form.email.unique' => 'Email sudah terdaftar.',
            'form.password.min' => 'Kata sandi minimal :min karakter.',
        ];

        $rules = [
            'form.name' => 'required|min:3',
            'form.email' => 'required|email|unique:users,email,' . $this->editingId,
            'form.password' => 'nullable|min:8',
        ];

        $validated = $this->validate($rules, $messages);

        $user = User::findOrFail($this->editingId);
        $user->name = $validated['form']['name'];
        $user->email = $validated['form']['email'];
        if (!empty($validated['form']['password'])) {
            $user->password = $validated['form']['password'];
        }
        $user->save();

        $this->resetForm();
        $this->successMessage = 'Pengguna berhasil diperbarui.';
        $this->showForm = false;
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->successMessage = 'Pengguna berhasil dihapus.';
        $this->resetPage();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm()
    {
        $this->form = [
            'name' => '',
            'email' => '',
            'password' => '',
        ];
        $this->editingId = null;
        $this->resetValidation();
    }
}
