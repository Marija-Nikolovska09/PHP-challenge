<?php 
    $file = file_get_contents('./review.json'); 
    $file = str_replace("\xEF\xBB\xBF",'', $file);  
    $dataObj = json_decode($file, true);

    $today = strtotime(date("Y-m-d"));

    function compareByTimeStamp($time1, $time2)
    {
        if (strtotime($time1) < strtotime($time2))
            return 1;
        else if (strtotime($time1) > strtotime($time2)) 
            return -1;
        else
            return 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <title>Reviews</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-8 offset-md-2 my-4">
                <h1>Filter Reviews</h1>
                <form method="POST" action="./index.php">
                    <div class="form-group">
                        <label for="rating">Order by rating:</label>
                        <select class="form-control" name="rating" id="rating" required>
                            <option value="Highest-First">Highest First</option>
                            <option value="Lowest-First">Lowest First</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="min-rating">Minimum rating:</label>
                        <select class="form-control" name="min-rating" id="min-rating" required>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Oreder by date:</label>
                        <select class="form-control" name="date" id="date">
                            <option value="newest-first">Newest First</option>
                            <option value="oldest-first">Oldest First</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prioritize_text">Prioritize by text:</label>
                        <select class="form-control" name="prioritize_text" id="prioritize_text" required>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <button class="btn btn-success my-4" type="submit">Filter</button>
                </form>
            </div>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // this is if user submit the form with some of edited inputs

                print_r($_POST);
                echo "<br/>";
                echo "<b>Filtered data:</b>";
                foreach ($dataObj as $object) {
                    if ($object["rating"] >= $_POST["min-rating"]) {
                        if ($object["reviewCreatedOnTime"] > ($today <= $object["reviewCreatedOnTime"]) && $_POST["date"] == "newest-first") {
                            if ($_POST["prioritize_text"] == "yes" && $object["reviewText"] > 0) {
                                echo "<pre>";
                                print_r($object);
                                echo "</pre>";
                                
                            } else if ($_POST["prioritize_text"] == "no" && $object["reviewText"] <= 0) {
                                echo "<pre>";
                                print_r($object);
                                echo "</pre>";
                                
                            }
                        } else if ($object["reviewCreatedOnTime"] <= $today && $_POST["date"] == "oldest-first") {
                            if ($_POST["prioritize_text"] == "yes" && $object["reviewText"] > 0) {
                                echo "<pre>";
                                print_r($object);
                                echo "</pre>";
                                
                            } else if ($_POST["prioritize_text"] == "no" && $object["reviewText"] <= 0) {
                                echo "<pre>";
                                print_r($object);
                                echo "</pre>";
                                
                            }
                        }
                    }
                }
                // this is default if just user select text priority and date, done like asked in PDF

                foreach ($dataObj as $object) {
                    if ($_POST["prioritize_text"] == "yes" && $object["reviewText"] > 0) {
                        if ($object["rating"] >= 3) {
                            if ($_POST["date"] == "oldest-first") {
                                $arr = [$object["reviewCreatedOnTime"]];
                                usort($arr, "compareByTimeStamp");
                                print_r($arr);
                            } else {
                                echo "<pre>";
                                print_r($object);
                                echo "</pre>";
                            }
                        }
                    } else if ($_POST["prioritize_text"] == "no" && $object["reviewText"] <= 0) {
                        if ($object["rating"] >= 3) {
                            echo "<pre>";
                            print_r($object);
                            echo "</pre>";
                        }
                    }
                }
            } else {
                echo "<pre>";
                print_r($dataObj);
            } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>