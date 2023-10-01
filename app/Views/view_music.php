<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="jsmusic/boot.css;">
    <link rel="stylesheet" href="jsmusic/script.js;">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f5f5f5;
        padding: 20px;
    }

    h1 {
        color: #333;
    }

    #player-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    audio {
        width: 100%;
    }

    #playlist {
        list-style: none;
        padding: 0;
    }

    #playlist li {
        cursor: pointer;
        padding: 10px;
        background-color: #eee;
        margin: 5px 0;
        transition: background-color 0.2s ease-in-out;
    }

    #playlist li:hover {
        background-color: #ddd;
    }

    #playlist li.active {
        background-color: #007bff;
        color: #fff;
    }
    </style>
</head>

<body>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <br>
                    <h4>My Playlists:</h4>
                    <ul id="playlistList">
                        <?php foreach ($playlists as $playlist): ?>
                        <p class="text-left">
                            <a href="/viewplaylists/<?php echo $playlist['id']; ?>"><button class="btn btn-primary text-center" style="padding-left: 80px; padding-right: 80px;"><?php echo $playlist['name']; ?></button></a>
                        </p>
                        <?php endforeach; ?>
                    </ul>

                    <br>


                </div>
                <div class="modal-footer">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#uploadMusic">Upload Music</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createPlaylist">Create New</a>


                </div>
            </div>
        </div>
    </div>
    <form action="/" method="get">
        <input type="search" name="search" placeholder="search song">
        <button type="submit" class="btn btn-primary">search</button>
    </form>
    <h1>Music Player</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        My Playlist
    </button>

    <!-- <audio id="audio" controls autoplay></audio> -->
    <!-- <ul id="playlist">

        <li data-src="/your music src">music name
        </li>

    </ul> -->
    <audio id="audio" controls autoplay></audio>
    <ul id="playlist">
        <?php foreach ($tracks as $track): ?>
        <?php
        $trackPath = base_url('/uploads/audio/' . $track['audio_file']);
        $trackExtension = pathinfo($track['audio_file'], PATHINFO_EXTENSION);
    ?>
        <li data-src="<?= $trackPath ?>">
            <?= pathinfo($track['audio_file'], PATHINFO_FILENAME) . '.' . $trackExtension ?>
            <button class="add-to-playlist-btn" data-bs-toggle="modal" data-bs-target="#addingModal"
            data-track-id="<?= $track['id'] ?>">Add</button>
            <form action="/Playlist/deletethistoo" method="post">
                <input type="hidden" name="id" value="<?= $track['id'] ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </li>

        <?php endforeach; ?>
    </ul>



    <div class="modal fade" id="addingModal" tabindex="-1" aria-labelledby="addingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addingModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="/Playlist/addtoplaylist" method="post">
                        <div class="mb-3">
                            <label for="playlist" class="form-label">Select Playlist</label>
                            <input type="hidden" name="id" id="trackId">

                            <select class="form-control" id="myplaylist" name="myplaylist" required>
                                <?php foreach ($playlists as $playlist): ?>
                                <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Playlist</button>
                    </form>


                </div>
                
            </div>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Select from playlist</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="/" method="post">
                        <!-- <p id="modalData"></p> -->
                        <input type="hidden" id="musicID" name="musicID">
                        <select name="playlist" class="form-control">

                            <option value="playlist">playlist</option>

                        </select>
                        <input type="submit" name="add">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Add this modal at the bottom of your HTML body -->
    <div class="modal fade" id="createPlaylist" tabindex="-1" aria-labelledby="createPlaylistLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPlaylistLabel">Create New Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/playlist/create" method="post">
                        <div class="mb-3">
                            <label for="playlistName" class="form-label">Playlist Name</label>
                            <input type="text" class="form-control" id="playlistName" name="playlistName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Playlist</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadMusic" tabindex="-1" aria-labelledby="uploadMusicLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadMusicLabel">Upload Music</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Playlist/uploadaudio" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="audio_file" class="form-label">Choose an Audio File</label>
                            <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio"
                                required>

                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    // JavaScript to handle button click event and set track ID in the hidden input field
    $(document).ready(function () {
        $('.add-to-playlist-btn').click(function () {
            var trackId = $(this).data('track-id');
            $('#trackId').val(trackId);
        });
    });
</script>

    <script>
    $(document).ready(function() {
        // Get references to the button and modal
        const modal = $("#myModal");
        const modalData = $("#modalData");
        const musicID = $("#musicID");
        // Function to open the modal with the specified data
        function openModalWithData(dataId) {
            // Set the data inside the modal content
            modalData.text("Data ID: " + dataId);
            musicID.val(dataId);
            // Display the modal
            modal.css("display", "block");
        }

        // Add click event listeners to all open modal buttons

        // When the user clicks the close button or outside the modal, close it
        modal.click(function(event) {
            if (event.target === modal[0] || $(event.target).hasClass("close")) {
                modal.css("display", "none");
            }
        });
    });
    </script>
     
<script>
    $(document).ready(function () {
        const audio = document.getElementById('audio');
        const playlist = document.getElementById('playlist');
        const playlistItems = playlist.querySelectorAll('li');
        const modal = new bootstrap.Modal(document.getElementById('myModal'));
        const musicID = document.getElementById('music_id');

        let currentTrack = 0;

        function playTrack(trackIndex) {
            if (trackIndex >= 0 && trackIndex < playlistItems.length) {
                const track = playlistItems[trackIndex];
                const trackSrc = track.getAttribute('data-src');
                audio.src = trackSrc;
                audio.play();
                currentTrack = trackIndex;

                // Update the music name
                const musicNameElement = document.getElementById('musicName');
                musicNameElement.textContent = track.textContent; // Assuming the text content of the list item is the music name
            }
        }

        playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                playTrack(index);
            });
        });

        audio.addEventListener('ended', () => {
            currentTrack = (currentTrack + 1) % playlistItems.length;
            playTrack(currentTrack);
        });

//         $(".add-to-playlist-btn").click(function () {
//     const trackIndex = $(this).parent().index();
//     const trackSrc = $(this).parent().attr("data-src");
//     const trackName = $(this).parent().text().trim();

//     // Set the selected music ID in the hidden input field
//     $("#music_id").val(trackIndex);

//     // Set the track name in the modal
//     $("#musicName").text(trackName);

//     // Show the "Add to Playlist" modal
//     $("#myModal").modal("show");
// });

// $("#myModal form").submit(function (event) {
//     event.preventDefault();
//     const playlistID = $("#playlist").val();
//     const musicIDValue = $("#music_id").val();

//     // Perform the necessary actions to add the music to the selected playlist
//     $.ajax({
//         url: "/add-music-to-playlist",
//         method: "POST",
//         data: {
//             playlistID: playlistID,
//             musicID: musicIDValue
//         },
//         success: function (response) {
//             // Display a success message or perform any other desired actions
//             alert("Song added to playlist with ID: " + playlistID);
//             $("#myModal").modal("hide");
//         },
//         error: function (error) {
//             // Handle the error case
//             console.error(error);
//         }
//     });
// });

        // playTrack(currentTrack);
    });
</script>
    <!-- <script>
    $(document).ready(function () {
        // Add click event listeners to all "Add to Playlist" buttons
        $(".add-to-playlist-btn").click(function () {
            // Retrieve the necessary data from the selected song
            const trackSrc = $(this).parent().attr("data-src");
            const trackName = $(this).parent().text().trim();

            // Perform the necessary actions to add the song to the playlist
            // For example, you can make an AJAX request to a server endpoint to add the song to the playlist

            // Display a success message or perform any other desired actions
            alert("Song added to playlist: " + trackName);
        });
    });
</script> -->
</body>

</html>