<?php
namespace App\Controllers;
use App\Models\PlaylistsModel;
use App\Models\PlaytrackModel;
use App\Models\TracksModel;
use CodeIgniter\Files\File;


use CodeIgniter\Controller;
class Playlist extends Controller {

    private $tracksm;

    public function __construct()
    {
        
        $this->tracksm = new \App\Models\TracksModel;
    }
    public function index(){
        $playm = new PlaylistsModel();
        $playmu = new TracksModel();
        $data =
        [
            'tracks' => $playmu->orderBy('id', 'DESC')->findAll(),
            'playlists' => $playm->orderBy('id', 'DESC')->findAll()
            // 'tracks' = $tm->orderBy('id', 'DESC')->findAll(),
    ];
       
        return view('view_music', $data);
    }

    public function play($audioId) {
        // Load the database model
        $model = new \App\Models\TracksModel();

        // Retrieve audio data from the database by ID
        $audioData = $model->find($audioId);

        if (!$audioData) {
            return "Audio not found";
        }

        // Output the audio data with the appropriate content type
        header("Content-type: audio/mpeg"); // Adjust content type as needed
        echo $audioData['audio_file'];
    }
   

    public function viewplays($id = null){
        $data = [
            'my' => $this->tracksm->where('myplaylist', $id)->findAll(),
        ];
        return view('view_playlists', $data);
    }
    

    public function addtoplaylist()
    {
        $id = $this->request->getPost('id');
        $data = [
            'myplaylist' => $this->request->getPost('myplaylist'),
            
        ];
        if ($this->tracksm->update($id, $data)) {
            return redirect()->to('/');
        }
   }

   public function deletethis()
    {
        $id = $this->request->getPost('id');
        $data = [
            'myplaylist' => '',
            
        ];
        if ($this->tracksm->update($id, $data)) {
            return redirect()->to(base_url('viewplaylists/' . $id));
        }
   }

   public function deletethistoo()
    {
        $id = $this->request->getPost('id');
        
        if ($this->tracksm->delete($id)) {
            return redirect()->to('/');
        }
    }

    public function create()
{
    // Get the playlist name from the form submission
    $playlistName = $this->request->getPost('playlistName');

    // Check if the playlist name is not empty
    if (!empty($playlistName)) {
        // Insert the new playlist into your database
        // You should have a PlaylistModel for database interactions
        $playlistModel = new \App\Models\PlaylistsModel();
        $data = [
            'name' => $playlistName,
        ];
        $playlistModel->insert($data);

        // Create the playlist folder
        $playlistFolder = 'uploads/playlist/' . $playlistName;
        if (!file_exists($playlistFolder)) {
            mkdir($playlistFolder, 0777, true);
        }

        // Optionally, you can redirect the user to the playlist page or perform other actions
        return redirect()->to('/')->with('success', 'Playlist created successfully');
    } else {
        // Handle the case when the playlist name is empty
        return redirect()->to('/')->with('error', 'Playlist name cannot be empty');
    }
}

    public function uploadaudio()
    {
        $tm = new TracksModel();
        $file = $this->request->getFile('audio_file');
        $MusicName = null; // Initialize $MusicName
    
        // Check if the file is valid
        if (!$file->isValid()) {
            die('File is not valid. Error: ' . $file->getError());
        }
    
        // Check if the file has already been moved
        if ($file->hasMoved()) {
            die('File has already been moved');
        }
    
        // Get the original name of the file
        $MusicName = $file->getName();
    
        // Move the uploaded file to the 'uploads/audio/' directory
        if (!$file->move('uploads/audio/', $MusicName)) {
            die('Failed to move file');
        }
    
        if ($MusicName !== null) {
            // Save the file name in the database
            $data = [
                'audio_file' => $MusicName, // Save the full filename including the extension
            ];
    
            if (!$tm->insert($data)) {
                // Print error message
                die($tm->errors());
            } else {
                // Redirect with a success message
                return redirect()->to('/')->with('status', 'Music saved');
            }
        } else {
            // Handle the case where 'audio_file' is null, e.g., show an error message or take appropriate action.
            return redirect()->to('/ERROR')->with('error', 'Failed to save music file.');
        }
    }

    
}    
?>