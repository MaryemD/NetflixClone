<?php
class Entity
{

    private $con, $sqlData;
    //If the input is the entity ID we fetch the data from database by the entity ID, if the input is already an array (sqlData) then we just
    //assign it to the sqlData variable.
    public function __construct($con, $input)
    {
        $this->con = $con;

        if (is_array($input)) {
            $this->sqlData = $input;
        } else {
            $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }
    //getting the data from the sql table
    public function getId()
    {
        return $this->sqlData["id"];
    }
    public function getName()
    {
        return $this->sqlData["name"];
    }

    public function getThumbnail()
    {
        return $this->sqlData["thumbnail"];
    }

    public function getPreview()
    {
        return $this->sqlData["preview"];
    }

}

?>