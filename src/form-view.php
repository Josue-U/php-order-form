<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Order Pizzas & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order pizzas in restaurant "the Personal Pizza Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active"  href="?food=1">Order pizzas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>

    <?php if (!empty($erreurEmail)) { ?>
        <?php echo $erreurEmail ?> 
    <?php } ?>

    <?php if (!empty($erreurStreet)) { ?>
        <?php echo $erreurStreet ?>
    <?php } ?>

    <?php if (!empty($erreurStreetNumber)) { ?>
         <?php echo $erreurStreetNumber ?>
    <?php } ?>

    <?php if (!empty($erreurCity)) { ?>
         <?php echo $erreurCity ?>
    <?php } ?>

    <?php if (!empty($erreurZipcode)) { ?>
            <?php echo $erreurZipcode ?>
    <?php } ?>
    
    <?php if (!empty($time)) { ?>
        <?php echo '<div class="alert alert-success" role="alert">Your order will arrive at '.$time.'  °.*\(^o^)/*.°</div>'; ?>
    <?php } ?>

    <form method="post" action="index.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $email ?>"/> 
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo $street ?>"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo $streetNumber ?>"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo $city ?>"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $zipcode ?>"/>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($menuSwitch AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        
        <label>
            <input type="checkbox" name="express_delivery" value="5" /> 
            Express delivery (+ 5 EUR) 
        </label>
            
        <button type="submit" name="order" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in pizza(s) and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
