<?php
include 'header.php';
include 'ft.php';
include 'db.php';

if (isset($_GET['entityId'])) {
    $id = $_GET['entityId'];

    $query = $con->prepare("SELECT * FROM videos WHERE entityId = :id");
    $query->bindValue(':id', $id);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo '<div class="container" style="margin-top: 100px;">
                <div class="head" style="padding: 10px 0">
                  <h1>Videos List</h1>
                  <hr>
                  <a class="btn btn-dark" href="addVideo.php?entityId=' . $id . '">Add New Video</a>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Title</th>
                      <th scope="col">Upload Date</th>
                      <th scope="col">Release Date</th>
                      <th scope="col">Duration</th>';
        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if ($row['isMovie'] == 0) {
                echo '<th class="aligned" scope="col">Season Number</th>
                          <th class="aligned" scope="col">Episode Number</th>
                          <th class="aligned" scope="col">Delete Video</th>';
            }
        }
        echo '</tr>
              </thead>
              <tbody>';

        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . $row['title'] . '</td>
                    <td>' . $row['uploadDate'] . '</td>
                    <td>' . $row['releaseDate'] . '</td>
                    <td>' . $row['duration'] . '</td>';
            if ($row['isMovie'] == 0) {
                echo '<td>' . $row['season'] . '</td>
                          <td>' . $row['episode'] . '</td>
                          <td class="aligned"><a href="deleteVideo.php?videoId=' . $row['id'] . '"><i class="fa-solid fa-trash" style="color: black"></i></a></td>';
            }
            echo '</tr>';
        }
        echo '</tbody>
            </table>
          </div>';
    } else {
        echo "<script>alert('No videos found for the specified entity ID.'); window.location.replace('entitiesList.php');</script>";
    }
} else {
    echo "<script>alert('No ID passed in URL.'); window.location.replace('entitiesList.php');</script>";
}
?>
