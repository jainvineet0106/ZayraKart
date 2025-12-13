<?php 
namespace App\Models;
use CodeIgniter\Model;
class StaffModel extends Model
{
    protected $table      = 'staff';   // table ka naam
    protected $primaryKey = 'id';             // primary key column
    protected $allowedFields = ['username', 'name', 'password', 'email', 'mobile']; // insert/update hone wale fields
}