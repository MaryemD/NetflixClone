<?php

//This class handles displaying the Video Previews
class PreviewProvider
{

    private $con, $username;

    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;
    }
    //The wanted preview can be of a random entity(the entity argument is expected to be null in this case) or of a specific entity
    public function createPreviewVideo($entity)
    {
        if ($entity == null) {
            $entity = $this->getRandomEntity();
        }
        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();


        $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);
        $video = new Video($this->con, $videoId);


        $inProgress = $video->isInProgress($this->username);
        $playButtonText = $inProgress ? "Continue Watching" : "Play";


        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";
        //Using fontawesome for the icons as they are easily modifiable
        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>

                        <source src='$preview' type='video/mp4'>
                    
                    </video>

                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subHeading
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fa-solid fa-play'></i>$playButtonText</button>
                                <button onclick='volumeToggle(this)'><i class='fa-solid fa-volume-xmark'></i></button>
                            </div>
                        </div>
                    </div>

                </div>";
    }


    public function createEntityPreviewSquare($entity)
    {
        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

    private function getRandomEntity()
    {

        $entity = EntityProvider::getEntities($this->con, null, 1);
        return $entity[0];

    }
}

?>