<?php

  // gets the seasons for each entity (except movies)

  class SeasonProvider{
    private $con, $username;

    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;
    }

    //orders entity's videos by season (html)
    public function create($entity){
      $seasons = $entity->getSeasons();

      if(sizeof($seasons) == 0){
        return;
      }

      $seasonsHtml = "";

      foreach($seasons as $season){
        $seasonNumber =  $season->getSeasonNumber();

        $videosHtml = "";

        foreach($season->getVideos() as $video){
          $videosHtml .= $this->createVideoSquare($video);
        }

        $seasonsHtml .= "<div class='season'>
                            <h3>Season $seasonNumber</h3>
                            <div class='videos'>
                              $videosHtml
                            </div>
                          </div>";

      }

      return $seasonsHtml;

    }

    //html for video square

    private function createVideoSquare($video){
      $id = $video->getId();
      $name = $video->getTitle();
      $description = $video->getDescription();
      $thumbnail = $video->getThumbnail();
      $episodeNumber = $video->getEpisodeNumber();

      return "<a href='watch.php?id=$id'>
                <div class='episodeContainer'>
                  <div class='contents'>
                    <img src = '$thumbnail'>
                    <div class='videoInfo'>
                      <h4>$episodeNumber. $name</h4>
                      <span>$description</span>
                    </div>
                  </div>
                </div>
              </a>";

    }

  }

?>