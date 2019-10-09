<?php

namespace tdp\events;

class EventManager
{
    /**
     * @var array[] The list of event listeners.
     */
    protected $listeners = [];

    /**
     * Subscribe to an event.
     *
     * @param string    $eventName
     * @param callable  $handler
     * @param int       $priority
     * 
     * @return void
     */
    public function on($eventName, $handler, $priority = 10)
    {
        $eventName = $this->normalizeEventName($eventName);

        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = [(int)$priority, $handler];
    }

    /**
     * Subscribe to an event exactly once.
     *
     * @param string   $eventName
     * @param callable $handler
     * @param int      $priority
     * 
     * @return void
     */
    public function once($eventName, $handler, $priority = 10)
    {
        $eventName = $this->normalizeEventName($eventName);
        $eManager  = $this;

        $wrapper = null;
        $wrapper = function () use ($eventName, $handler, &$wrapper, $eManager) {
            $eManager->remove($eventName, $wrapper);

            return call_user_func_array($handler, func_get_args());
        };

        $this->on($eventName, $wrapper, $priority);
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param string   $eventName
     * @param array    $args
     * @param mixed    $context
     * 
     * @return void
     */
    public function trigger($eventName, array $args = [])
    {
        $eventName = $this->normalizeEventName($eventName);
        $listeners = $this->getListeners($eventName);

        foreach ($listeners as $event => $listener) {
            call_user_func_array($listener, $args);
        }
    }

    /**
     * Removes a specific listener from an event.
     *
     * @param string $eventName
     * 
     * @return bool
     */
    public function remove($eventName)
    {
        $eventName = $this->normalizeEventName($eventName);

        if (!isset($this->listeners[$eventName])) {
            return false;
        }

        $this->listeners[$eventName] = [];

        return true;
    }

    /**
     * Prepare event namebefore using.
     *
     * @param string $eventName
     * 
     * @return string
     */
    protected function normalizeEventName($eventName)
    {
        return $eventName;
    }

    /**
     * Returns the list of listeners for an event.
     *
     * The list is returned as an array, and the list of events are sorted by
     * their priority.
     *
     * @param string $eventName
     * 
     * @return array
     */
    protected function getListeners($eventName)
    {
        if (!isset($this->listeners[$eventName])) {
            return [];
        }

        $result = $this->listeners[$eventName];

        usort($result, function ($item1, $item2) {
            return $item2[0] - $item1[0];
        });

        return array_map(function ($item) {
            return $item[1];
        }, $result);
    }
}
