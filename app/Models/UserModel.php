<?php 
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model
{
    protected $table      = 'user_accounts';   // table ka naam
    protected $primaryKey = 'id';             // primary key column
    protected $allowedFields = ['name', 'password', 'email', 'mobile', 'address', 'image']; // insert/update hone wale fields
}