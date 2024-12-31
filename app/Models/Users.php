<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','username','email','password','role'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getFilteredUsers($filterRole = null, $filterName = null, $filterEmail = null) {
        if ($filterRole) {
            $this->where('role', $filterRole);
        }
        if ($filterName) {
            $this->like('username', $filterName);
        }
        if ($filterEmail) {
            $this->like('email', $filterEmail);
        }
        return $this->paginate(3);
    }

    public function isUsernameExists($username) {
        return $this->where('username', $username)->first() !== null;
    }

    public function isEmailExists($email) {
        return $this->where('email', $email)->first() !== null;
    }

    public function createUser ($username, $email, $password, $role) {
        $this->save([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);
    }

    public function getUserById($id) {
        return $this->where('user_id', $id)->first();
    }

    public function updateUser ($id, $username, $email, $role) {
        $this->update($id, [
            'username' => $username,
            'email' => $email,
            'role' => $role
        ]);
    }

    public function deleteUser ($id) {
        $this->delete($id);
    }

    public function getUserByEmail($email) {
        return $this->where('email', $email)->first();
    }

    public function getUserByRole($role) {
        return $this->where('role', $role)->find();
    }

}
