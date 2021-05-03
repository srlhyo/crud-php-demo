<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeatherSafe APP</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="display-4  text-center my-5">Very simple WeatherSafe Database CRUD APP</h1>
        <?php if(!$isApiCorrect) : ?>
            <small id="note">**provide your ApiKey to use the services</small>
            <form id="apiForm" class="row g-3 mt-1" method="GET">
                <div class="col-md-6">
                    <label for="apiKey" class="form-label">Api Key</label>
                    <input type="text" name="apikey" class="form-control" id="apiKey">
                </div>
                <div class="col-auto align-self-end">
                    <input type="submit" name="submit" class="btn btn-primary" id="getFields" value="Get Fields">
                </div>
                <?php if($showStatus) : ?>
                    <small class="<?= $isApiCorrect ? "text-success" : "text-danger" ?>" id="isApiCorrect"><?php echo $isApiCorrect ? "Success" : "Error"?></small>
                <?php endif; ?>
            </form>
        <?php endif; ?>
        <div style="margin-top: 5px;">
            <small class="text-danger"><?php echo $showError ? $errorMessage : ""; ?></small>
        </div>
        
        <?php if($isApiCorrect && !$showError) { require "table.php";} ?> 
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>