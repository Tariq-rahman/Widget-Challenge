<?php

class Widget{

    /**
     * @var array
     */
    private $packSizes;

    /**
     * @var int
     */
    private $numWidgets;

    /**
     * Widget constructor, Initializes the variables
     * @param $numberOfWidgets
     * @param $sizeList, the sizes of each packet in ascending order
     */
    public function __construct($numberOfWidgets, $sizeList) {
        $this->numWidgets = $numberOfWidgets;
        $this->packSizes = $sizeList;
    }

    /**
     * Finds the largest packet size that is smaller than the number
     * by looping though all the packet sizes in descending order
     *
     * @param $number
     * @return int index of packSizes, the index of the packet size for the packetSize array
     * returns the min pack size if the number is less than the min pack size
     */
    public function getLowerBound($number)
    {
        for ($i = array_key_last($this->packSizes); $i > 0; $i--) {
            if ($number >= $this->packSizes[$i]) {
                return $i;
            }
        }
        return 0;
    }


    /**
     * Finds the smallest packet size that is greater than the number
     * by looping through all the packet sizes in ascending order
     *
     * @param $number
     * @return int index of packSizes, the index of the packet size for the packetSize array
     * returns the max pack size if the number is greater than the max size
     */
    public function getUpperBound($number)
    {
        for ($i = 0; $i < count($this->packSizes); $i++) {
            if ($number <= $this->packSizes[$i]) {
                return $i;
            }
        }

        return end($this->packSizes);
    }

    /**
     * Calculates the required packets to fulfil the widget order
     *
     * @return array|mixed
     */
    public function calculatePackets()
    {
        $resultList = [];
        //clear easy situation
        if ($this->numWidgets <= $this->packSizes[0]) {
            $this->numWidgets -= $this->packSizes[0];
            // use null coalesce operator to avoid undefined array key warning
            $resultList[$this->packSizes[0]] = $resultList[$this->packSizes[0]] ?? null + 1;
        }
        //Keep using max size widget until it is within max widget range
        if ($this->numWidgets >= end($this->packSizes)) {
            $resultList[end($this->packSizes)] = floor($this->numWidgets / end($this->packSizes));
            $this->numWidgets = $this->numWidgets % end($this->packSizes);
        }

        while ($this->numWidgets > 0) {
            // Find where the number of widget sits in the range of packet sizes
            $upperIndex = $this->getUpperBound($this->numWidgets);
            $lowerIndex = $this->getLowerBound($this->numWidgets);
            $upperDiff = abs($this->numWidgets - $this->packSizes[$upperIndex]);
            $lowerDiff = abs($this->useLower($this->numWidgets));

            //find which solution wastes the least number of widgets
            //if they are the same, use larger packet to reduce number of packets.
            if ($upperDiff == $lowerDiff || $upperDiff < $lowerDiff) {
                $this->numWidgets -= $this->packSizes[$upperIndex];
                $resultList[$this->packSizes[$upperIndex]] = $resultList[$this->packSizes[$upperIndex]] ?? null + 1;
            } else {
                $this->numWidgets -= $this->packSizes[$lowerIndex];
                $resultList[$this->packSizes[$lowerIndex]] = $resultList[$this->packSizes[$lowerIndex]] ?? null +1;
            }
        }

        return $resultList;
    }

    /**
     * Uses the lower bounds to minimise waste widgets
     *
     * @param $number
     * @return array
     */
    public function useLower($number)
    {
        while( $number > 0) {
            $lowerBound = $this->getLowerBound($number);
            $number = $number - $this->packSizes[$lowerBound];
        }
        return $number;
    }
}
