<?php

$widget = new Widget(12501, [250,500,1000,2000,5000]);
print_r($widget->calculatePackets());

class Widget{

    private $packSizes = [];
    private $packList = [];
    private $numWidgets = 0;
    private $maxSize;

    /**
     * Widget constructor, Initializes the variables
     * @param $numberOfWidgets
     * @param $sizeList, the sizes of each packet in ascending order
     */
    public function __construct($numberOfWidgets, $sizeList){
        $this->numWidgets = $numberOfWidgets;
        $this->packSizes = $sizeList;
        $this->maxSize = count($sizeList) -1;
    }

    /**Finds the largest packet size that is smaller than the number
     * by looping though all the packet sizes in descending order
     *
     * @param $number
     * @return int, the index of the packet size for the packetSize array
     * -1 means there is no lower bound, the number is smaller than the min packet size
     */
    public function getLowerBound($number)
    {
        for($i = $this->maxSize; $i > 0; $i--){
            if($number > $this->packSizes[$i]){
                return $i;
            }
        }
        return -1;
    }


    /**Finds the smallest packet size that is greater than the number
     * by looping through all the packet sizes in ascending order
     *
     * @param $number
     * @return int, the index of the packet size for the packetSize array
     * -1 means there is no upper bound, the number is greater than the max packet size
     */
    public function getUpperBound($number)
    {
        for($i = 0; $i < count($this->packSizes); $i++){
            if($number < $this->packSizes[$i]){
                return $i;
            }
        }
        return -1;
    }

    /**Calculates the required packets to fulfil the widget order
     *
     * @return array|mixed
     */
    public function calculatePackets()
    {
        //clear easy situation
        if ($this->numWidgets <= $this->packSizes[0]) {
            return $this->packSizes[0];
        }
        //Keep using max size widget until it is within max widget range
        while( $this->numWidgets >= $this->packSizes[$this->maxSize]) {
            $this->numWidgets = $this->numWidgets - $this->packSizes[$this->maxSize];
            $this->packList[] = $this->packSizes[$this->maxSize];
        }
        $upperBound = $this->getUpperBound($this->numWidgets);
        // Using the larger packet size here will guarantee that minimum packets, but not minimum widgets
        $upperDiff = $this->numWidgets - $this->packSizes[$upperBound];
        $lowerDiff = $this->useLower($this->numWidgets);
        // find which solution wastes the least number of widgets
        //if they are the same, use larger packet to reduce number of packets.
        if(abs($upperDiff) == abs($lowerDiff['diff']) || abs($upperDiff) < abs($lowerDiff['diff'])){
            $this->packList[] = $this->packSizes[$upperBound];
            return $this->packList;
        } else {
            array_push($this->packList, ...$lowerDiff['packList']);
            return $this->packList;
        }
    }

    /**Uses the lower bounds to minimise waste widgets
     *
     * @param $number
     * @return array
     */
    public function useLower($number)
    {
        $tempArr =[];
        while( $number > 0){
            $lowerBound = $this->getLowerBound($number);
            if($lowerBound < 0){
                $lowerBound = 0;
            }
            $number = $number - $this->packSizes[$lowerBound];
            $tempArr[] = $this->packSizes[$lowerBound];
        }
        return ['diff' => $number, 'packList' =>$tempArr];
    }
}

