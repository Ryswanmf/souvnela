<?php

namespace App\Models;

use CodeIgniter\Model;

class InfoPageModel extends Model
{
    protected $table            = 'info_pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['slug', 'title', 'content'];
    protected $useTimestamps    = true;
}
