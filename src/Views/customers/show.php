<?php
include __DIR__ . "/../app.php";
?>

<main>


    <?php if ($orders) : ?>

        <?php foreach($orders as $order): ?>


            <div class="sticker">
                <p>Order Price: <?= $order->price; ?></p>
                <p>Point A: <?=$order->point_a; ?></p>
                <p>Point B: <?= $order->point_b; ?></p>
                <p>Class: <?= $order->class; ?></p>
                <p>Order status: <?= $order->status; ?> </p>
                <?php if ($taxiDriver) : ?>
                    <p>TaxiDriver: {{ $order['TaxiDriver']->firstName}}</p>
                    @if($order['TaxiDriver']->rating != null)
                    <p>TaxiDriver Rating: {{ $order['TaxiDriver']->rating}}</p>
                    @endif
                    <p>Car Color: {{ $order['Car']->color}}</p>
                    <p>Car Brand: {{ $order['Car']->brand}}</p>
                <?php endif; ?>

                <?php if ($order->status == 2 || $order->status == 1) : ?>

                    <form action="/order/update" method="POST">
                        <input name="orderId" id="orderId" type="hidden" value="{{$order->id}}">
                        <input name="customerId" id="customerId" type="hidden" value="{{$order->customerId}}">
                        <input name="action" class = "Decline" id="DeclineAsCustomer" type="submit" value="Decline">
                    </form>

                <?php endif; ?>


                <?php if ($order->status == 4 && !$order->reviewGiven) : ?>

                    <form action="/order/update" id = "starsForm" method="POST">
                        <input name="orderId" id="orderId" type="hidden" value="{{$order->id}}">
                        <input name="customerId" id="customerId" type="hidden" value="{{$order->customerId}}">
                        <input type="hidden" name="rating" id="rating" value="">
                        <span class="star" data-value="1">★</span>
                        <span class="star" data-value="2">★</span>
                        <span class="star" data-value="3">★</span>
                        <span class="star" data-value="4">★</span>
                        <span class="star" data-value="5">★</span> <br>
                        <input name="action" class = "Decline" id="Submit" type="submit" value="Leave Review">
                    </form>
                    <script>
                        let stars = document.querySelectorAll('.star');

                        for (let i = 0; i < stars.length; i++) {
                            stars[i].addEventListener('click', function() {
                                let rating = this.getAttribute('data-value');
                                document.getElementById('rating').value = rating;

                                for (let j = 0; j < stars.length; j++) {
                                    if (j < rating) {
                                        stars[j].textContent = '★';
                                    } else {
                                        stars[j].textContent = '☆';
                                    }
                                }
                            });
                        }
                    </script>

                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    <?php endif ?>


</main>

<?php
include __DIR__ . "/../footer.php";
?>




