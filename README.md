# Payment
...

# Example
```php
try {
    $transId = Payment::nextpay()->order([
        'orderId'     => '1',
        'amount'      => '1000',
        'callBackUrl' => 'http://matmag.ir',
    ]);

    Payment::nextpay()->verify([
        'orderId' => '1',
        'amount'  => '1000',
        'transId' => $transId,
    ]);

    echo 'Successful';
} catch (ConnectionFail $e) {
    echo $e->getMessage();
} catch (OrderException $e) {
    printf('Order Error, ID: %d - Message: %s', $e->getId(), $e->getMessage());
}
```