<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
\FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

echo "=== Test FedaPay API ===\n";
echo "Environment: " . config('fedapay.environment') . "\n";
echo "API Key: " . substr(config('fedapay.secret_key'), 0, 10) . "...\n\n";

try {
    // Test 1: Check available classes
    echo "1. Available FedaPay classes:\n";
    $classes = get_declared_classes();
    $fedapay_classes = array_filter($classes, function($c) { return strpos($c, 'FedaPay') !== false; });
    foreach ($fedapay_classes as $class) {
        echo "   - $class\n";
    }
    echo "\n";

    // Test 2: Create a test customer
    echo "2. Testing customer creation...\n";
    try {
        $customer = \FedaPay\Customer::create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone_number' => [
                'number' => '+22964123456',
                'country' => 'BJ',
            ],
        ]);
        echo "   Customer created: {$customer->id}\n\n";
    } catch (\Exception $e) {
        echo "   Customer creation error: " . $e->getMessage() . "\n";
        if (method_exists($e, 'getResponse')) {
            echo "   Response: " . $e->getResponse() . "\n";
        }
        echo "\n";
    }

    // Test 3: Test payout creation (without sending)
    echo "3. Testing payout creation...\n";
    try {
        $payout = \FedaPay\Payout::create([
            'amount' => 1000,
            'currency' => ['iso' => 'XOF'],
            'mode' => 'mtn',
            'description' => 'Test payout',
            'customer' => [
                'firstname' => 'Test',
                'lastname' => 'User',
                'email' => 'test@example.com',
                'phone_number' => [
                    'number' => '+22964123456',
                    'country' => 'BJ',
                ],
            ],
        ]);
        echo "   Payout created: {$payout->id}\n";
        echo "   Payout status: {$payout->status}\n\n";

        // Test 4: Attempt to send payout
        echo "4. Testing payout send...\n";
        try {
            $payout->sendNow();
            echo "   Payout sent successfully!\n";
        } catch (\Exception $e) {
            echo "   Send error: " . $e->getMessage() . "\n";
        }
    } catch (\Exception $e) {
        echo "   Payout creation error: " . $e->getMessage() . "\n";
        if (method_exists($e, 'getResponse')) {
            echo "   Response: " . $e->getResponse() . "\n";
        }
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
