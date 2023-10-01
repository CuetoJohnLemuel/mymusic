<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        <h1>Music Player</h1>
    <div id="player-container">
        <h4>Playlist Name: </h4>

        <audio id="audio" controls autoplay></audio>

        <ul id="playlist">
            <?php foreach ($my as $musicko): ?>
                <?php
                $trackPath = base_url('/uploads/audio/' . $musicko['audio_file']);
                $trackExtension = pathinfo($musicko['audio_file'], PATHINFO_EXTENSION);
                ?>
                  <li data-src="<?= $trackPath ?>">
            <?= pathinfo($musicko['audio_file'], PATHINFO_FILENAME) . '.' . $trackExtension ?>
            <span>
            <form action="/Playlist/deletethis" method="post">
                <input type="hidden" name="id" value="<?= $musicko['id'] ?>">
                <button class="btn btn-danger" type="submit" >Delete</button>
            </form>
            </span>
            
        </li>

            <?php endforeach; ?>
        </ul>

    </div>

    <script>
        $(document).ready(function () {
            const audio = document.getElementById('audio');
            const playlist = document.getElementById('playlist');
            const playlistItems = playlist.querySelectorAll('li');
            const musicNameElement = document.getElementById('musicName');
            
            let currentTrack = 0;

            function playTrack(trackIndex) {
                if (trackIndex >= 0 && trackIndex < playlistItems.length) {
                    const track = playlistItems[trackIndex];
                    const trackSrc = track.getAttribute('data-src');
                    audio.src = trackSrc;
                    audio.play();
                    currentTrack = trackIndex;

                    // Update the music name
                    musicNameElement.textContent = track.textContent;
                    playlistItems.forEach((item, index) => {
                        if (index === trackIndex) {
                            item.classList.add('active');
                        } else {
                            item.classList.remove('active');
                        }
                    });
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
            
            // Initial play
            playTrack(currentTrack);
        });
    </script>
</body>

</html>
