<?php

/**
 * 
 */
class movie_Model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->loadOtherModel('category');
        $this->loadOtherModel('season');
        $this->loadOtherModel('episode');
        $this->loadOtherModel('mvtype');
        $this->loadOtherModel('mvfile');
        $this->loadOtherModel('movie_category');
        $this->loadOtherModel('movie_season');
        // $this->loadOtherModel('resolution');
        // $this->loadOtherModel('episode_file');
        // $this->loadOtherModel('season_episode');
    }

    public function rows()
    {

        $query = "SELECT id FROM movies";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }

    public function insert_old($data)
    {
        $name = $data['name'];
        $release_year = $data['release_year'];
        $description = $data['description'];
        $movie_type_id = $data['movie_type_id'];
        $poster_landscape     = $data['poster_landscape'];
        $poster_portrait     = $data['poster_portrait'];
        $created_datetime = date('y-m-d h:m:s');
        $catObjList = $data['category'];

        $catcount=count($catObjList);
        $category_id = [];
        for($i = 0; $i < $catcount; $i++){
            $category_id[] = $catObjList[$i]['id'];
        }

        $totalcategory = count($category_id);

        $season_list = $data['season_list'];
        $totalseason = count($season_list);



        // print_r($data);
        // exit;

        try {

            $this->db->beginTransaction();

            //first query
            $query = "INSERT INTO movies SET name =:name,release_year=:release_year,description=:description,movie_type_id=:movie_type_id,poster_landscape=:poster_landscape,poster_portrait=:poster_portrait,created_datetime =:created_datetime ";

            // prepare first query
            $stmt = $this->db->prepare($query);

            // bind new values
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':release_year', $release_year);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':movie_type_id', $movie_type_id);
            $stmt->bindParam(':poster_landscape', $poster_landscape);
            $stmt->bindParam(':poster_portrait', $poster_portrait);
            $stmt->bindParam(':created_datetime', $created_datetime);


            // execute the query
            $stmt->execute();

            $movieid = $this->db->lastInsertId();
            if (!$movieid) {
                throw new \Exception("Something went wrong");
            }


            for ($i = 0; $i < $totalcategory; $i++) {
                $categorydata['movie_id'][] = $movieid;
                $categorydata['category_id'][] = $category_id[$i];
                $categorydata['created_datetime'][] = $created_datetime;
            }

            $check_category = $this->db->multiInsert2($categorydata, 'movie_category');
            if (!$check_category) {
                throw new \Exception("Something went wrong in movie_category insert");
            }


            for ($j = 0; $j < $totalseason; $j++) {
                $each_season = $season_list[$j];
                $seasonname = $each_season['season_description'];
                $season_movie_id = $movieid;
                $season_season_id = $each_season['season']['id'];
                //$season_season_id = $each_season['season'];
                $season_created_datetime = $created_datetime;
                $query = "INSERT INTO movie_season SET name =:name,movie_id=:movie_id,season_id=:season_id,created_datetime =:created_datetime ";

                // prepare first query
                $stmt = $this->db->prepare($query);

                // bind new values
                $stmt->bindParam(':name', $seasonname);
                $stmt->bindParam(':movie_id', $season_movie_id);
                $stmt->bindParam(':season_id', $season_season_id);
                $stmt->bindParam(':created_datetime', $season_created_datetime);


                // execute the query
                $check_season = $stmt->execute();

                //$check_season = $this->movie_seasonmodel->insertone($movie_season_data);

                if (!$check_season) {
                    throw new \Exception("Something went wrong in movie season");
                } else {
                    $movie_seasonid = $this->db->lastInsertId();
                }




                $episode_list = $each_season['episode_list'];
                $totalepisode = count($episode_list);

                for ($k = 0; $k < $totalepisode; $k++) {
                    $each_episode = $episode_list[$k];
                    $episodeid = $each_episode['episode']['id'];
                    //$episodeid = $each_episode['episode'];
                    $episodename = $each_episode['episode_description'];
                    $movie_season_id = $movie_seasonid;
                    $duration = $each_episode['duration'];
                    $episode_created_datetime = $created_datetime;
                    $query = "INSERT INTO season_episode SET name =:name,duration=:duration,movie_season_id=:movie_season_id,episode_id=:episode_id,created_datetime =:created_datetime ";

                    // prepare first query
                    $stmt = $this->db->prepare($query);

                    // bind new values
                    $stmt->bindParam(':name', $episodename);
                    $stmt->bindParam(':duration', $duration);
                    $stmt->bindParam(':movie_season_id', $movie_season_id);
                    $stmt->bindParam(':episode_id', $episodeid);
                    $stmt->bindParam(':created_datetime', $episode_created_datetime);


                    // execute the query
                    $check_episode = $stmt->execute();
                    //$check_episode = $this->season_episodemodel->insertone($season_episode_data);
                    if (!$check_episode) {
                        throw new \Exception("Something went wrong in season_episode insert");
                    } else {
                        $season_episode_id = $this->db->lastInsertId();
                    }


                    $file_list = $each_episode['file_model_list'];
                    $totalfile = count($file_list);
                    for ($l = 0; $l < $totalfile; $l++) {
                        $each_file = $file_list[$l];
                        $file_name = $each_file['name'];
                        $file_size = $each_file['file_size'];
                        //$resolution_id = $each_file['resolution'];
                        $resolution_id = $each_file['resolution']['id'];
                        $file_created_datetime = $created_datetime;

                        $query = "INSERT INTO mvfiles SET name=:name,file_size =:file_size,resolution_id=:resolution_id,created_datetime =:created_datetime ";

                        // prepare first query
                        $stmt = $this->db->prepare($query);

                        // bind new values

                        $stmt->bindParam(':name', $file_name);
                        $stmt->bindParam(':file_size', $file_size);
                        $stmt->bindParam(':resolution_id', $resolution_id);
                        $stmt->bindParam(':created_datetime', $file_created_datetime);


                        // execute the query
                        $check_file = $stmt->execute();
                        //$check_file = $this->mvfilemodel->insertone($file_data);
                        if (!$check_file) {
                            throw new \Exception("Something went wrong in file insert");
                        } else {
                            $file_id = $this->db->lastInsertId();
                        }



                        $query = "INSERT INTO episode_file SET season_episode_id =:season_episode_id,file_id=:file_id,created_datetime =:created_datetime ";

                        // prepare first query
                        $stmt = $this->db->prepare($query);

                        // bind new values

                        $stmt->bindParam(':season_episode_id', $season_episode_id);
                        $stmt->bindParam(':file_id', $file_id);
                        $stmt->bindParam(':created_datetime', $file_created_datetime);


                        // execute the query
                        $check_episode_file = $stmt->execute();
                        //$check_episode_file = $this->episode_filemodel->insertone($episode_file_data);

                        if (!$check_episode_file) {
                            throw new \Exception("Something went wrong in episode_file insert");
                        }
                    }

                    //    echo 'files:';
                    //    echo $totalfile;
                }

                //    echo 'episodes:';
                //    echo $totalepisode;
            }

            // echo 'seasons:';
            // echo $totalseason;

            $this->db->commit();

            //return true;
            return $this->readone($movieid);
        } catch (Exception $e) {
            //An exception has occured, which means that one of our database queries failed.
            //Print out the error message.
            echo $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
            return false;
        }

    }

    public function insert($data)
    {
        $name = $data['name'];
        $release_year = $data['release_year'];
        $description = $data['description'];
        $movie_type_id = $data['movie_type_id'];
        $poster_landscape     = $data['poster_landscape'];
        $poster_portrait     = $data['poster_portrait'];
        $created_datetime = date('y-m-d h:m:s');

        $category_id = $data['category_id'];
        $totalcategory = count($category_id);

        $season_list = $data['season_list'];
        $totalseason = count($season_list);



        // print_r($data);
        // exit;

        try {

            $this->db->beginTransaction();

            //first query
            $query = "INSERT INTO movies SET name =:name,release_year=:release_year,description=:description,movie_type_id=:movie_type_id,poster_landscape=:poster_landscape,poster_portrait=:poster_portrait,created_datetime =:created_datetime ";

            // prepare first query
            $stmt = $this->db->prepare($query);

            // bind new values
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':release_year', $release_year);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':movie_type_id', $movie_type_id);
            $stmt->bindParam(':poster_landscape', $poster_landscape);
            $stmt->bindParam(':poster_portrait', $poster_portrait);
            $stmt->bindParam(':created_datetime', $created_datetime);


            // execute the query
            $stmt->execute();

            $movieid = $this->db->lastInsertId();
            if (!$movieid) {
                throw new \Exception("Something went wrong");
            }


            for ($i = 0; $i < $totalcategory; $i++) {
                $categorydata['movie_id'][] = $movieid;
                $categorydata['category_id'][] = $category_id[$i];
                $categorydata['created_datetime'][] = $created_datetime;
            }

            $check_category = $this->db->multiInsert2($categorydata, 'movie_category');
            if (!$check_category) {
                throw new \Exception("Something went wrong in movie_category insert");
            }


            for ($j = 0; $j < $totalseason; $j++) {
                $each_season = $season_list[$j];
                $movie_season_data['name'] = $each_season['season_description'];
                $movie_season_data['movie_id'] = $movieid;
                $movie_season_data['season_id'] = $each_season['season'];
                $movie_season_data['created_datetime'] = $created_datetime;

                echo "transaction begin";
                //$check_season = $this->db->insert($movie_season_data,'movie_season');
                $check_season = $this->movie_seasonmodel->insertreturnid($movie_season_data);

                echo "transaction finish " . $check_season;

                if (!$check_season) {
                    throw new \Exception("Something went wrong in movie season");
                } else {
                    //$movie_seasonid = $this->db->lastInsertId();
                    $movie_seasonid = $check_season;
                }




                $episode_list = $each_season['episode_list'];
                $totalepisode = count($episode_list);

                for ($k = 0; $k < $totalepisode; $k++) {
                    $each_episode = $episode_list[$k];
                    $season_episode_data['episode_id'] = $each_episode['episode'];
                    $season_episode_data['name'] = $each_episode['episode_description'];
                    $season_episode_data['movie_season_id'] = $movie_seasonid;
                    $season_episode_data['duration'] = $each_episode['duration'];
                    $season_episode_data['created_datetime'] = $created_datetime;


                    $check_episode = $this->season_episodemodel->insertreturnid($season_episode_data);
                    //$check_episode = $this->db->insert($season_episode_data,'season_episode');

                    if (!$check_episode) {
                        throw new \Exception("Something went wrong in season_episode insert");
                    } else {
                        $season_episode_id = $check_episode;
                        //$season_episode_id = $this->db->lastInsertId();
                    }


                    $file_list = $each_episode['file_model_list'];
                    $totalfile = count($file_list);
                    for ($l = 0; $l < $totalfile; $l++) {
                        $each_file = $file_list[$l];
                        $file_data['name'] = $each_file['name'];
                        $file_data['file_size'] = $each_file['file_size'];
                        $file_data['resolution_id'] = $each_file['resolution'];
                        $file_data['created_datetime'] = $created_datetime;



                        $check_file = $this->mvfilemodel->insertreturnid($file_data);
                        //$check_file = $this->db->insert($file_data,'mvfiles');

                        if (!$check_file) {
                            throw new \Exception("Something went wrong in file insert");
                        } else {
                            $file_id = $check_file;
                            //$file_id = $this->db->lastInsertId();
                        }



                        $episode_file_data['season_episode_id'] = $season_episode_id;
                        $episode_file_data['file_id'] = $file_id;
                        $episode_file_data['created_datetime'] = $created_datetime;



                        $check_episode_file = $this->episode_filemodel->insert($episode_file_data);
                        //$check_episode_file = $this->db->insert($episode_file_data,'episode_file');

                        if (!$check_episode_file) {
                            throw new \Exception("Something went wrong in episode_file insert");
                        }
                    }

                    //    echo 'files:';
                    //    echo $totalfile;
                }

                //    echo 'episodes:';
                //    echo $totalepisode;
            }

            // echo 'seasons:';
            // echo $totalseason;

            $this->db->commit();



            //return true;
            return $this->read($movieid);
        } catch (Exception $e) {
            //An exception has occured, which means that one of our database queries failed.
            //Print out the error message.
            echo $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
            return false;
        }
    }
    
    public function readone_old($where)
    {
        $server = "https://" . $_SERVER['SERVER_NAME'];
        
        $dir       = '/datshin/datshin-backend-api/uploads/';
        //$dir       = '/uploads/';
        $path = $server . $dir;
        $query = "SELECT  * FROM movies as m
            LEFT JOIN (SELECT GROUP_CONCAT(category_id) as category_id , movie_id FROM movie_category GROUP BY movie_id) as category ON m.id=category.movie_id
            LEFT JOIN (SELECT GROUP_CONCAT(id) as season_id , movie_id FROM movie_season GROUP BY movie_id) as season ON m.id=season.movie_id
            WHERE m.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $category_id = explode(",", $category_id);
                $category_arr = array();
                foreach ($category_id as  $value) {
                    $catwhere = $value;
                    $categorydata = $this->categorymodel->readone($catwhere);
                    $category_arr[] = $categorydata;
                }

                $season_id = explode(",", $season_id);
                $season_arr = array();
                foreach ($season_id as  $value) {
                    $seawhere = $value;
                    $seadata = $this->movie_seasonmodel->readone($seawhere);
                    $season_arr[] = $seadata;
                }


                $movie = array(
                    "id" => (int)$id,
                    "name" => $name,
                    "description" => $description,
                    "poster_portrait" =>  $poster_portrait,
                    "poster_landscape" => $poster_landscape,
                    "release_year" => (int)$release_year,
                    "movie_type" => (int)$movie_type_id,
                    "category" => $category_arr,
                    "season_list" => $season_arr
                );
            }
            return $movie;
        } else {
            return false;
        }
    }

    public function readone($where)
    {
        $server = "https://" . $_SERVER['SERVER_NAME'];
        $dir       = '/datshin/datshin-backend-api/uploads/';
        $path = $server . $dir;
        $query = "SELECT  * FROM movies as m
            LEFT JOIN (SELECT GROUP_CONCAT(category_id) as category_id , movie_id FROM movie_category GROUP BY movie_id) as category ON m.id=category.movie_id
            LEFT JOIN (SELECT GROUP_CONCAT(id) as season_id , movie_id FROM movie_season GROUP BY movie_id) as season ON m.id=season.movie_id
            WHERE m.id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $category_id = explode(",", $category_id);
                $category_arr = array();
                foreach ($category_id as  $value) {
                    $catwhere = $value;
                    $categorydata = $this->categorymodel->readone($catwhere);
                    $category_arr[] = $categorydata;
                }

                $season_id = explode(",", $season_id);
                $season_arr = array();
                foreach ($season_id as  $value) {
                    $seawhere = $value;
                    $seadata = $this->movie_seasonmodel->readone($seawhere);
                    $season_arr[] = $seadata;
                }


                $movie = array(
                    "id" => (int)$id,
                    "name" => $name,
                    "description" => $description,
                    "poster_portrait" => $path . $poster_portrait,
                    "poster_landscape" => $path . $poster_landscape,
                    "release_year" => (int)$release_year,
                    "movie_type" => (int)$movie_type_id,
                    "category" => $category_arr,
                    "season_list" => $season_arr
                );
            }
            return $movie;
        } else {
            return false;
        }
    }

    public function read($where = null, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;


        if ($limit !== null && $current !== null) {
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  m.id as movie_id FROM movies as m ORDER BY m.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($limit !== null && $current == null) {

            $query = "SELECT   m.id as movie_id FROM movies as m ORDER BY m.id  ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT   m.id as movie_id FROM movies as m ORDER BY m.id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
        } elseif ($where !== null) {

            $query = "SELECT   m.id as movie_id FROM movies as m WHERE m.id=?";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $where);
        } else {

            $query = "SELECT   m.id as movie_id FROM movies as m ORDER BY m.id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_arr = array();
        $movie_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie = $this->readone($movie_id);
                array_push($movie_arr, $movie);
            }
            return $movie_arr;
        } else {
            return false;
        }
    }

    public function readbycategory($category, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;


        if ($limit !== null && $current !== null) {
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  mc.movie_id FROM movie_category as mc WHERE mc.category_id=? ORDER BY mc.movie_id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $category);
        } elseif ($limit !== null && $current == null) {

            $query = "SELECT  mc.movie_id FROM movie_category as mc WHERE mc.category_id=? ORDER BY mc.movie_id ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $category);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  mc.movie_id FROM movie_category as mc WHERE mc.category_id=? ORDER BY mc.movie_id ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $category);
        } else {

            $query = "SELECT  mc.movie_id FROM movie_category as mc WHERE mc.category_id=? ORDER BY mc.movie_id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $category);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie = $this->readone($movie_id);
                array_push($movie_arr, $movie);
            }
            return $movie_arr;
        } else {
            return false;
        }
    }

    public function readbytype($type, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;


        if ($limit !== null && $current !== null) {
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  m.id FROM movies as m WHERE m.movie_type_id=? ORDER BY m.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $type);
        } elseif ($limit !== null && $current == null) {

            $query = "SELECT  m.id FROM movies as m WHERE m.movie_type_id=? ORDER BY m.id  ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $type);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  m.id FROM movies as m WHERE m.movie_type_id=? ORDER BY m.id  ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $type);
        } else {

            $query = "SELECT  m.id FROM movies as m WHERE m.movie_type_id=? ORDER BY m.id ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $type);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie = $this->readone($id);
                array_push($movie_arr, $movie);
            }
            return $movie_arr;
        } else {
            return false;
        }
    }

    public function readbyreleaseyear($releaseyear, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;


        if ($limit !== null && $current !== null) {
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  m.id FROM movies as m WHERE m.release_year=? ORDER BY m.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $releaseyear);
        } elseif ($limit !== null && $current == null) {

            $query = "SELECT  m.id FROM movies as m WHERE m.release_year=? ORDER BY m.id  ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $releaseyear);
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  m.id FROM movies as m WHERE m.release_year=? ORDER BY m.id  ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $releaseyear);
        } else {

            $query = "SELECT  m.id FROM movies as m WHERE m.release_year=? ORDER BY m.id  ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $releaseyear);
        }



        $stmt->execute();

        $num = $stmt->rowCount();
        $movie_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie = $this->readone($id);
                array_push($movie_arr, $movie);
            }
            return $movie_arr;
        } else {
            return false;
        }
    }

    public function readbyname($name, $current = null, $limit = null)
    {

        $limit = ($limit > 20) ? 20 : $limit;


        if ($limit !== null && $current !== null) {
            $firstlimit = $current;
            $secondlimit = $firstlimit + $limit;
            $query = "SELECT  m.id FROM movies as m WHERE m.name LIKE ? ORDER BY m.id ASC LIMIT $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            //$stmt->bindParam(':name', '%'.$name.'%');
        } elseif ($limit !== null && $current == null) {

            $query = "SELECT  m.id FROM movies as m WHERE m.name LIKE ? ORDER BY m.id  ASC LIMIT $limit";
            $stmt = $this->db->prepare($query);
            //$stmt->bindParam(':name', '%'.$name.'%');
        } elseif ($current !== null) {

            $firstlimit = $current;
            $secondlimit = (int)$firstlimit + 20;
            $query = "SELECT  m.id FROM movies as m WHERE m.name LIKE ? ORDER BY m.id  ASC LIMIT  $firstlimit,$secondlimit";
            $stmt = $this->db->prepare($query);
            //$stmt->bindParam(':name', '%'.$name.'%');
        } else {

            $query = "SELECT  m.id FROM movies as m WHERE m.name LIKE ? ORDER BY m.id  ASC LIMIT 20";
            $stmt = $this->db->prepare($query);
            //$stmt->bindParam(':name', '%'.$name.'%');
        }



        $stmt->execute(array('%' . $name . '%'));

        $num = $stmt->rowCount();
        $movie_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $movie = $this->readone($id);
                array_push($movie_arr, $movie);
            }
            return $movie_arr;
        } else {
            return false;
        }
    }

    public function episode_fileid($where)
    {
        $query = "SELECT  ef.file_id as id FROM episode_file as ef WHERE ef.season_episode_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);
        $stmt->execute();

        $num = $stmt->rowCount();


        if ($num > 0) {
            $file_id_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $file_id = (int)$id;
                $file_id_arr[] = $file_id;
            }
            return $file_id_arr;
        } else {
            return false;
        }
    }

    public function movie_seasonid($where)
    {
        $query = "SELECT  ms.id as id FROM movie_season as ms WHERE ms.movie_id=?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $where);
        $stmt->execute();

        $num = $stmt->rowCount();


        if ($num > 0) {
            $season_id_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $season_id = (int)$id;
                $season_id_arr[] = $season_id;
            }
            return $season_id_arr;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $movieid = $data['id'];
        $name = $data['name'];
        $release_year = $data['release_year'];
        $description = $data['description'];
        $movie_type_id = $data['movie_type_id'];
        $poster_landscape     = $data['poster_landscape'];
        $poster_portrait     = $data['poster_portrait'];
        $modified_datetime = date('y-m-d h:m:s');
        $created_datetime = date('y-m-d h:m:s');

        //$category_id = $data['category_id'];
        $catObjList = $data['category'];
        
        $catcount=count($catObjList);
        $category_id = [];
        for($i = 0; $i < $catcount; $i++){
            $category_id[] = $catObjList[$i]['id'];
        }

        //$totalcategory = count($category_id);
        $totalcategory = $catcount;

        $season_list = $data['season_list'];
        $totalseason = count($season_list);



        // print_r($data);
        // exit;

        try {

            $this->db->beginTransaction();

            //first query
            $query = "UPDATE movies SET name =:name,release_year=:release_year,description=:description,movie_type_id=:movie_type_id,poster_landscape=:poster_landscape,poster_portrait=:poster_portrait,modified_datetime =:modified_datetime WHERE id=:id";

            // prepare first query
            $stmt = $this->db->prepare($query);

            // bind new values
            $stmt->bindParam(':id', $movieid);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':release_year', $release_year);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':movie_type_id', $movie_type_id);
            $stmt->bindParam(':poster_landscape', $poster_landscape);
            $stmt->bindParam(':poster_portrait', $poster_portrait);
            $stmt->bindParam(':modified_datetime', $modified_datetime);
            $stmt->bindParam(':id', $movieid);


            // execute the query
            $stmt->execute();

            $movieid = $movieid;

            $ex_category_id = $this->movie_categorymodel->movie_categoryid($movieid);


            $delete_category_id = array_diff($ex_category_id, $category_id);
            $delete_totalcategory = count($delete_category_id);

            //$this->checkResult($delete_category_id,false);


            $insert_category_id = array_diff($category_id, $ex_category_id);
            $insert_totalcategory = count($insert_category_id);

            // print_r($insert_category_id);
            // exit;

            if ($delete_totalcategory > 0) {

                foreach ($delete_category_id as  $value) {

                    $query = "DELETE FROM movie_category WHERE movie_id=:movie_id AND category_id=:category_id";

                    // prepare second query
                    $stmt = $this->db->prepare($query);

                    // bind new values
                    $stmt->bindParam(':movie_id', $movieid);
                    $stmt->bindParam(':category_id', $value);
                    $stmt->execute();
                }
            }


            if ($insert_totalcategory > 0) {
                $categorydata = [];
                foreach ($insert_category_id as  $value) {

                    $categorydata['movie_id'][] = $movieid;
                    $categorydata['category_id'][] = $value;
                    $categorydata['created_datetime'][] = $created_datetime;
                }


                $check_category_insert = $this->db->multiInsert2($categorydata, 'movie_category');

                if (!$check_category_insert) {
                    throw new \Exception("Something went wrong in movie_category insert");
                }
            }



            $ex_movie_season_id_list = $this->movie_seasonid($movieid);
            $movie_season_list = [];

            for ($j = 0; $j < $totalseason; $j++) {
                $each_season = $season_list[$j];



                if (empty($each_season['id'])) {

                    $seasonname = $each_season['season_description'];
                    $season_movie_id = $movieid;
                    $season_season_id = $each_season['season']['id'];
                    //$season_season_id = $each_season['season'];
                    $season_created_datetime = $created_datetime;
                    $query = "INSERT INTO movie_season SET name =:name,movie_id=:movie_id,season_id=:season_id,created_datetime =:created_datetime ";

                    // prepare first query
                    $stmt = $this->db->prepare($query);

                    // bind new values
                    $stmt->bindParam(':name', $seasonname);
                    $stmt->bindParam(':movie_id', $season_movie_id);
                    $stmt->bindParam(':season_id', $season_season_id);
                    $stmt->bindParam(':created_datetime', $season_created_datetime);


                    // execute the query
                    $check_season = $stmt->execute();

                    //$check_season = $this->movie_seasonmodel->insertone($movie_season_data);

                    if (!$check_season) {
                        throw new \Exception("Something went wrong in movie season");
                    } else {
                        $movie_seasonid = $this->db->lastInsertId();
                    }




                    $episode_list = $each_season['episode_list'];
                    $totalepisode = count($episode_list);

                    for ($k = 0; $k < $totalepisode; $k++) {
                        $each_episode = $episode_list[$k];
                        //$episodeid = $each_episode['episode'];
                        $episodeid = $each_episode['episode']['id'];
                        $episodename = $each_episode['episode_description'];
                        $movie_season_id = $movie_seasonid;
                        $duration = $each_episode['duration'];
                        $episode_created_datetime = $created_datetime;
                        $query = "INSERT INTO season_episode SET name =:name,duration=:duration,movie_season_id=:movie_season_id,episode_id=:episode_id,created_datetime =:created_datetime ";

                        // prepare first query
                        $stmt = $this->db->prepare($query);

                        // bind new values
                        $stmt->bindParam(':name', $episodename);
                        $stmt->bindParam(':duration', $duration);
                        $stmt->bindParam(':movie_season_id', $movie_season_id);
                        $stmt->bindParam(':episode_id', $episodeid);
                        $stmt->bindParam(':created_datetime', $episode_created_datetime);


                        // execute the query
                        $check_episode = $stmt->execute();
                        //$check_episode = $this->season_episodemodel->insertone($season_episode_data);
                        if (!$check_episode) {
                            throw new \Exception("Something went wrong in season_episode insert");
                        } else {
                            $season_episode_id = $this->db->lastInsertId();
                        }


                        $file_list = $each_episode['file_model_list'];
                        $totalfile = count($file_list);
                        for ($l = 0; $l < $totalfile; $l++) {
                            $each_file = $file_list[$l];
                            $file_name = $each_file['name'];
                            $file_size = $each_file['file_size'];
                            //$resolution_id = $each_file['resolution'];
                            $resolution_id = $each_file['resolution']['id'];
                            $file_created_datetime = $created_datetime;

                            $query = "INSERT INTO mvfiles SET name=:name,file_size =:file_size,resolution_id=:resolution_id,created_datetime =:created_datetime ";

                            // prepare first query
                            $stmt = $this->db->prepare($query);

                            // bind new values

                            $stmt->bindParam(':name', $file_name);
                            $stmt->bindParam(':file_size', $file_size);
                            $stmt->bindParam(':resolution_id', $resolution_id);
                            $stmt->bindParam(':created_datetime', $file_created_datetime);


                            // execute the query
                            $check_file = $stmt->execute();
                            //$check_file = $this->mvfilemodel->insertone($file_data);
                            if (!$check_file) {
                                throw new \Exception("Something went wrong in file insert");
                            } else {
                                $file_id = $this->db->lastInsertId();
                            }



                            $query = "INSERT INTO episode_file SET season_episode_id =:season_episode_id,file_id=:file_id,created_datetime =:created_datetime ";

                            // prepare first query
                            $stmt = $this->db->prepare($query);

                            // bind new values

                            $stmt->bindParam(':season_episode_id', $season_episode_id);
                            $stmt->bindParam(':file_id', $file_id);
                            $stmt->bindParam(':created_datetime', $file_created_datetime);


                            // execute the query
                            $check_episode_file = $stmt->execute();
                            //$check_episode_file = $this->episode_filemodel->insertone($episode_file_data);

                            if (!$check_episode_file) {
                                throw new \Exception("Something went wrong in episode_file insert");
                            }
                        }

                        //    echo 'files:';
                        //    echo $totalfile;
                    }

                    //    echo 'episodes:';
                    //    echo $totalepisode;
                } else {
                    //season id ပါပါက

                    // echo 'season id ပါပါက';
                    // exit;

                    $where['id'] = $each_season['id'];
                    $movie_season_data['name'] = $each_season['season_description'];
                    $movie_season_data['movie_id'] = $movieid;
                    //$movie_season_data['season_id'] = $each_season['season'];
                    $movie_season_data['season_id'] = $each_season['season']['id'];
                    $movie_season_data['modified_datetime'] = $modified_datetime;

                    //$check_season = $this->db->insert($movie_season_data,'movie_season');
                    $check_season = $this->movie_seasonmodel->update($movie_season_data, $where);
                    $movie_season_list[] = $where['id'];

                    if (!$check_season) {
                        throw new \Exception("Something went wrong in movie season");
                    } else {
                        //$movie_seasonid = $this->db->lastInsertId();
                        $movie_seasonid =  $where['id'];
                    }

                    $episode_list = $each_season['episode_list'];
                    $totalepisode = count($episode_list);

                    $ex_episode_id_list_str = $this->movie_seasonmodel->episode_id($movie_seasonid);
                    $ex_episode_id_list = explode(",", $ex_episode_id_list_str);

                    //print_r($ex_episode_id_list);
                    // exit;

                    $episode_id_list = [];

                    for ($k = 0; $k < $totalepisode; $k++) {
                        $each_episode = $episode_list[$k];
                        if (empty($each_episode['id'])) {

                            //$episodeid = $each_episode['episode'];
                            $episodeid = $each_episode['episode']['id'];
                            $episodename = $each_episode['episode_description'];
                            $movie_season_id = $movie_seasonid;
                            $duration = $each_episode['duration'];
                            $episode_created_datetime = $created_datetime;
                            $query = "INSERT INTO season_episode SET name =:name,duration=:duration,movie_season_id=:movie_season_id,episode_id=:episode_id,created_datetime =:created_datetime ";

                            // prepare first query
                            $stmt = $this->db->prepare($query);

                            // bind new values
                            $stmt->bindParam(':name', $episodename);
                            $stmt->bindParam(':duration', $duration);
                            $stmt->bindParam(':movie_season_id', $movie_season_id);
                            $stmt->bindParam(':episode_id', $episodeid);
                            $stmt->bindParam(':created_datetime', $episode_created_datetime);


                            // execute the query
                            $check_episode = $stmt->execute();
                            //$check_episode = $this->season_episodemodel->insertone($season_episode_data);
                            if (!$check_episode) {
                                throw new \Exception("Something went wrong in season_episode insert");
                            } else {
                                $season_episode_id = $this->db->lastInsertId();
                            }


                            $file_list = $each_episode['file_model_list'];
                            $totalfile = count($file_list);
                            for ($l = 0; $l < $totalfile; $l++) {
                                $each_file = $file_list[$l];
                                $file_name = $each_file['name'];
                                $file_size = $each_file['file_size'];
                                //$resolution_id = $each_file['resolution'];
                                $resolution_id = $each_file['resolution']['id'];
                                $file_created_datetime = $created_datetime;

                                $query = "INSERT INTO mvfiles SET name=:name,file_size =:file_size,resolution_id=:resolution_id,created_datetime =:created_datetime ";

                                // prepare first query
                                $stmt = $this->db->prepare($query);

                                // bind new values

                                $stmt->bindParam(':name', $file_name);
                                $stmt->bindParam(':file_size', $file_size);
                                $stmt->bindParam(':resolution_id', $resolution_id);
                                $stmt->bindParam(':created_datetime', $file_created_datetime);


                                // execute the query
                                $check_file = $stmt->execute();
                                //$check_file = $this->mvfilemodel->insertone($file_data);
                                if (!$check_file) {
                                    throw new \Exception("Something went wrong in file insert");
                                } else {
                                    $file_id = $this->db->lastInsertId();
                                }



                                $query = "INSERT INTO episode_file SET season_episode_id =:season_episode_id,file_id=:file_id,created_datetime =:created_datetime ";

                                // prepare first query
                                $stmt = $this->db->prepare($query);

                                // bind new values

                                $stmt->bindParam(':season_episode_id', $season_episode_id);
                                $stmt->bindParam(':file_id', $file_id);
                                $stmt->bindParam(':created_datetime', $file_created_datetime);


                                // execute the query
                                $check_episode_file = $stmt->execute();
                                //$check_episode_file = $this->episode_filemodel->insertone($episode_file_data);

                                if (!$check_episode_file) {
                                    throw new \Exception("Something went wrong in episode_file insert");
                                }
                            }

                            //    echo 'files:';
                            //    echo $totalfile;
                        } else {

                            $where['id'] = $each_episode['id'];
                            //$season_episode_data['episode_id'] = $each_episode['episode'];
                            $season_episode_data['episode_id'] = $each_episode['episode']['id'];
                            $season_episode_data['name'] = $each_episode['episode_description'];
                            $season_episode_data['movie_season_id'] = $movie_seasonid;
                            $season_episode_data['duration'] = $each_episode['duration'];
                            $season_episode_data['modified_datetime'] = $modified_datetime;



                            $check_episode = $this->db->update($season_episode_data, 'season_episode', $where);
                            $episode_id_list[] = $where['id'];

                            if (!$check_episode) {
                                throw new \Exception("Something went wrong in season_episode insert");
                            } else {
                                $season_episode_id = $where['id'];
                            }


                            $file_list = $each_episode['file_model_list'];
                            $totalfile = count($file_list);

                            $ex_file_id_list = $this->episode_fileid($season_episode_id);
                            $file_id_list = [];

                            for ($l = 0; $l < $totalfile; $l++) {
                                $each_file = $file_list[$l];
                                if (empty($each_file['id'])) {

                                    $file_data['name'] = $each_file['name'];
                                    $file_data['file_size'] = $each_file['file_size'];
                                    $file_data['resolution_id'] = $each_file['resolution'];
                                    $file_data['resolution_id'] = $each_file['resolution']['id'];
                                    $file_data['created_datetime'] = $created_datetime;




                                    //$check_file = $this->mvfilemodel->insertreturnid($file_data);
                                    $check_file = $this->db->insert($file_data, 'mvfiles');

                                    // echo $check_file;
                                    // exit;

                                    if (!$check_file) {
                                        throw new \Exception("Something went wrong in file insert");
                                    } else {
                                        // $file_id = $check_file;
                                        $file_id = $this->db->lastInsertId();
                                    }

                                    // echo $file_id;
                                    // exit;



                                    $episode_file_data['season_episode_id'] = $season_episode_id;
                                    $episode_file_data['file_id'] = $file_id;
                                    $episode_file_data['created_datetime'] = $created_datetime;

                                    // print_r($episode_file_data);
                                    // exit;

                                    //$check_episode_file = $this->episode_filemodel->insert($episode_file_data);
                                    $check_episode_file = $this->db->insert($episode_file_data, 'episode_file');

                                    if (!$check_episode_file) {
                                        throw new \Exception("Something went wrong in episode_file insert");
                                    }
                                } else {
                                    $where['id'] = $each_file['id'];
                                    $file_data['name'] = $each_file['name'];
                                    $file_data['file_size'] = $each_file['file_size'];
                                    //$file_data['resolution_id'] = $each_file['resolution'];
                                    $file_data['resolution_id'] = $each_file['resolution']['id'];
                                    $file_data['modified_datetime'] = $modified_datetime;

                                    // print_r($file_data);
                                    // print_r($where);
                                    // exit;

                                    $check_file = $this->db->update($file_data, 'mvfiles', $where);

                                    if (!$check_file) {
                                        throw new \Exception("Something went wrong in file insert");
                                    }

                                    $file_id_list[] = $each_file['id'];
                                }
                            }

                            $delete_file_id_list = array_diff($ex_file_id_list, $file_id_list);
                            $delete_file_id_list_count = count($delete_file_id_list);

                            if ($delete_file_id_list_count > 0) {
                                foreach ($delete_file_id_list as  $value) {
                                    $wherefile['id'] = $value;
                                    $whereepisode['file_id'] = $value;

                                    $check_episodefile_delete = $this->db->delete($whereepisode, 'episode_file');
                                    $check_mvfile_delete = $this->db->delete($wherefile, 'mvfiles');

                                    if (!$check_episodefile_delete && !$check_mvfile_delete) {
                                        throw new \Exception("Something went wrong in file delete");
                                    }
                                }
                            }
                        }

                        //    echo 'files:';
                        //    echo $totalfile;
                    }
                    // print_r($episode_id_list);
                    // exit;

                    $delete_episode_id_list = array_diff($ex_episode_id_list, $episode_id_list);
                    $delete_episode_id_list_count = count($delete_episode_id_list);

                    // print_r($delete_episode_id_list);
                    // exit;

                    if ($delete_episode_id_list_count > 0) {

                        foreach ($delete_episode_id_list as  $value) {
                            $whereseasonepisode['id'] = $value;
                            $file_id_list = $this->episode_fileid($value);

                            foreach ($file_id_list as  $value) {
                                $wherefile['id'] = $value;
                                $whereepisode['file_id'] = $value;

                                $check_episodefile_delete = $this->db->delete($whereepisode, 'episode_file');
                                $check_mvfile_delete = $this->db->delete($wherefile, 'mvfiles');

                                if (!$check_episodefile_delete && !$check_mvfile_delete) {
                                    throw new \Exception("Something went wrong in file delete");
                                }
                            }


                            $check_episode_delete = $this->db->delete($whereseasonepisode, 'season_episode');


                            if (!$check_episode_delete) {
                                throw new \Exception("Something went wrong in episode delete");
                            }
                        }
                    }

                    //    echo 'episodes:';
                    //    echo $totalepisode;
                }
            }

            $delete_season_id_list = array_diff($ex_movie_season_id_list, $movie_season_list);
            // print_r($ex_movie_season_id_list);
            //print_r($movie_season_list);
            //print_r($delete_season_id_list);

            foreach ($delete_season_id_list as  $value) {
                $wheremovieseason['id'] = $value;
                $episode_id_list_str = $this->movie_seasonmodel->episode_id($value);
                $episode_id_list = explode(",", $episode_id_list_str);


                foreach ($episode_id_list as  $value) {
                    $whereseasonepisode['id'] = $value;
                    $file_id_list = $this->episode_fileid($value);

                    foreach ($file_id_list as  $value) {
                        $wherefile['id'] = $value;
                        $whereepisode['file_id'] = $value;

                        $check_episodefile_delete = $this->db->delete($whereepisode, 'episode_file');
                        $check_mvfile_delete = $this->db->delete($wherefile, 'mvfiles');

                        if (!$check_episodefile_delete && !$check_mvfile_delete) {
                            throw new \Exception("Something went wrong in file delete");
                        }
                    }


                    $check_episode_delete = $this->db->delete($whereseasonepisode, 'season_episode');


                    if (!$check_episode_delete) {
                        throw new \Exception("Something went wrong in episode delete");
                    }
                }


                $check_season_delete = $this->db->delete($wheremovieseason, 'movie_season');


                if (!$check_season_delete) {
                    throw new \Exception("Something went wrong in season delete");
                }
            }




            // echo 'seasons:';
            // echo $totalseason;

            $this->db->commit();



            //return true;
            return $this->readone($movieid);
        } catch (Exception $e) {
            //An exception has occured, which means that one of our database queries failed.
            //Print out the error message.
            echo $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
            return false;
        }
    }

    public function delete($where)
    {
        $movieid = $where;
        $wheremovie['id']=$where;
        try {
            $this->db->beginTransaction();

            $movie_season_id_list = $this->movie_seasonid($movieid);
            foreach ($movie_season_id_list as  $value) {
                $wheremovieseason['id'] = $value;
                $episode_id_list_str = $this->movie_seasonmodel->episode_id($value);
                $episode_id_list = explode(",", $episode_id_list_str);


                foreach ($episode_id_list as  $value) {
                    $whereseasonepisode['id'] = $value;
                    $file_id_list = $this->episode_fileid($value);

                    foreach ($file_id_list as  $value) {
                        $wherefile['id'] = $value;
                        $whereepisode['file_id'] = $value;

                        $check_episodefile_delete = $this->db->delete($whereepisode, 'episode_file');
                        $check_mvfile_delete = $this->db->delete($wherefile, 'mvfiles');

                        if (!$check_episodefile_delete && !$check_mvfile_delete) {
                            throw new \Exception("Something went wrong in file delete");
                        }
                    }


                    $check_episode_delete = $this->db->delete($whereseasonepisode, 'season_episode');


                    if (!$check_episode_delete) {
                        throw new \Exception("Something went wrong in episode delete");
                    }
                }


                $check_season_delete = $this->db->delete($wheremovieseason, 'movie_season');


                if (!$check_season_delete) {
                    throw new \Exception("Something went wrong in season delete");
                }
            }
            $category_id_list = $this->movie_categorymodel->movie_categoryid($movieid);
            foreach ($category_id_list as  $value) {

                $query = "DELETE FROM movie_category WHERE movie_id=:movie_id AND category_id=:category_id";

                // prepare second query
                $stmt = $this->db->prepare($query);

                // bind new values
                $stmt->bindParam(':movie_id', $movieid);
                $stmt->bindParam(':category_id', $value);
                $stmt->execute();
            }

            $check_movie_delete = $this->db->delete($wheremovie, 'movies');


            if (!$check_movie_delete) {
                throw new \Exception("Something went wrong in movie delete");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            //An exception has occured, which means that one of our database queries failed.
            //Print out the error message.
            echo $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
            return false;
        }
    }

}
