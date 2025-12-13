<?php 
namespace App\Models;
use CodeIgniter\Model;
class AdminModel extends Model
{
    protected $table      = 'admin';   // table ka naam
    protected $primaryKey = 'id';             // primary key column
    protected $allowedFields = ['username', 'password']; // insert/update hone wale fields
}