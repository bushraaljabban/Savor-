<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
    <h1>Menu</h1>
    <ul>
        @foreach ($menuItems as $item)
            <li>{{ $item['name'] }} - ${{ $item['price'] }}</li>
        @endforeach
    </ul>
    <a href="{{ route('login') }}">Login to Order</a>
    @auth
    <h2>Place an Order</h2>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required min="1">

        <button type="submit">Order</button>
    </form>
@endauth
@guest
    <p>Please <a href="{{ route('login') }}">login</a> to place an order.</p>
@endguest

</body>
</html>
