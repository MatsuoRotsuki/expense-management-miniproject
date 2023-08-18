<?php

class Collection implements Iterator {

    private $items = [];
    private $index = 0; 

    public function current() {
        return $this->items[$this->index];
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index++;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return isset($this->items[$this->key()]);
    }

    public function __construct(array $items) {
        $this->items = $items;
    }

    public function setItems(array $items){
        $this->items = $items;
    }

    public function getItems() {
        return $this->items;
    }
}

