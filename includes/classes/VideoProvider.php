<?php
/*This class is responsible for fetching the next video to be played after the current video is finished playing.
It is demonstrated by selecting the next video in the same season and episode number as the current video.
If there is no next video in the same season and episode number, the next video will be the first video of the series
with the highest views.*/



class VideoProvider {
    public static function getUpNext($con, $currentVideo) {
        $query = $con->prepare("SELECT * FROM videos
                            WHERE entityId=:entityId AND id != :videoId
                            AND (
                                (season = :season AND episode > :episode) OR season > :season
                            )
                            ORDER BY season, episode ASC LIMIT 1");
        $query->bindValue(":entityId", $currentVideo->getEntityId());
        $query->bindValue(":season", $currentVideo->getSeasonNumber());
        $query->bindValue(":episode", $currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId", $currentVideo->getId());

        $query->execute();

        if($query->rowCount() == 0) {
            $query = $con->prepare("SELECT * FROM videos
                                    WHERE season <=1 AND episode <= 1
                                    AND id != :videoId
                                    ORDER BY views DESC LIMIT 1");
            $query->bindValue(":videoId", $currentVideo->getId());
            $query->execute();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return new Video($con, $row);
    }



    public static function getEntityVideoForUser($con, $entityId, $username) {
        $query = $con->prepare("SELECT videoId FROM `videoProgress` 
                                INNER JOIN videos
                                ON videoProgress.videoId = videos.id
                                WHERE videos.entityId = :entityId 
                                AND videoProgress.username = :username
                                ORDER BY videoProgress.dateModified DESC
                                LIMIT 1");
        $query->bindValue(":entityId", $entityId);
        $query->bindValue(":username", $username);
        $query->execute();

        if($query->rowCount() == 0) {
            $query = $con->prepare("SELECT id FROM videos 
                                    WHERE entityId=:entityId
                                    ORDER BY season, episode ASC LIMIT 1");
            $query->bindValue(":entityId", $entityId);
            $query->execute();
        }

        return $query->fetchColumn();
    }
}
?>
