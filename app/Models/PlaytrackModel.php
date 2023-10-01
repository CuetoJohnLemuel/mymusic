<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaytrackModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'playlist_track';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['playlist_id', 'track_id'];

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

    // application/models/Playlist_model.php

// class Playlist_model extends CI_Model {
//     public function createPlaylist($playlistName) {
//         // Insert the new playlist into the database
//         $data = array(
//             'name' => $playlistName,
//         );
//         $this->db->insert('playlist', $data);

//         // Return the ID of the newly created playlist
//         return $this->db->insert_id();
//     }
// }


}
