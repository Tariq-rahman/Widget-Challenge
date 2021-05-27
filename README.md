# Widget-Challenge
My solution to the Wally's widget challenge, uses PHP version 7.3

## Scenario and specification 
Wally’s Widget Company is a widget wholesaler. They sell widgets in a variety of pack sizes:
- 250 widgets
- 500 widgets
- 1,000 widgets
- 2,000 widgets
- 5,000 widgets

Their customers can order any number of widgets, but they will always be given complete packs.
The company wants to be able to fulfil all orders according to the following rules:
1. Only whole packs can be sent. Packs cannot be broken open.
2. Within the constraints of Rule 1 above, send out no more widgets than necessary to fulfil
the order.
3. Within the constraints of Rules 1 & 2 above, send out as few packs as possible to fulfil each
order.

| Number of Widgets ordered | Correct packs to send | 
| -------- | -------- | 
| 1     | 250 x 1     | 
|250 |250 x 1|
|251 | 500 x 1|
|501 | 500 x 1 250 x 1|
|12001|[5000 x 2 2000 x 1 250 x 1|

## How to use
Fastest way to see the code in action is to copy the code and paste it into an online PHP sandbox and click run.
you can test out different sizes of packets and widgets by playing around with the parameters of the widget object on line 3.

The other way of running this is to download the repo and run the `script.php` from the command line.

When assigning the pack sizes, they must be in ascending order.

- Like this `Widget(152, [250,500,1000,2000,5000])`
- Not like this `Widget(152, [500,400,300,200,100])`

## Output 
The output of the script uses `print_r` to print out the array so it will look something like this `Array ( [5000] => 2 [2000] => 1 [500] => 1)` where the array key is the packet size and the value is the quantity of that packet size.
