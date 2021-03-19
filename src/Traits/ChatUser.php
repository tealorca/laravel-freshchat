<?php

namespace TealOrca\LaravelFreshchat\Traits;

trait ChatUser
{
    /**
     * Retrieve the Freshchat User ID.
     *
     * @return string|null
     */
    public function freshchatId()
    {
        return (isset($this->attributes['freshchat_id']) ? trim($this->attributes['freshchat_id']) : null);
    }

    /**
     * Get the Freshchat User ID.
     *
     * @return string|null
     */
    public function getFreshchatIdAttribute()
    {
        return $this->freshchatId();
    }

    /**
     * Determine if the customer has a Freshchat User ID.
     *
     * @return bool
     */
    public function hasFreshchatId(): bool
    {
        return !is_null($this->freshchat_id);
    }

    /**
     * Determine if the customer has a Freshchat User ID.
     *
     * @return bool
     */
    public function getHasFreshchatIdAttribute()
    {
        return $this->hasFreshchatId();
    }

    /**
     * Retrieve the RestoreId column value.
     *
     * @return string|null
     */
    public function getRestoreIdColumn()
    {
        return (isset($this->freshchatRestoreId) ? trim($this->freshchatRestoreId) : null);
    }

    /**
     * Get the Freshchat User Init Details.
     *
     * @return array
     */
    public function getFreshchatUserInitDetails(): array
    {
        $initDetails = array();

        // $initable = $this->chatInitable();

        // $externalIdColumn = (isset($initable['externalId']) ? trim($initable['externalId']) : null);
        // $initDetails['externalId'] = (isset($externalIdColumn) && isset($this->attributes[$externalIdColumn]) ? trim($this->attributes[$externalIdColumn]) : null);

        // $restoreIdColumn = (isset($initable['restoreId']) ? trim($initable['restoreId']) : null);
        // $initDetails['restoreId'] = (isset($restoreIdColumn) && isset($this->attributes[$restoreIdColumn]) ? trim($this->attributes[$restoreIdColumn]) : null);

        if (method_exists($this, $method = 'chatUserExternalId')) {
            $initDetails['externalId'] = $this->{$method}();
        }else{
            $initDetails['externalId'] = $this->email;
        }

        $restoreIdColumn = $this->getRestoreIdColumn();
        $initDetails['restoreId'] = (isset($restoreIdColumn) && isset($this->attributes[$restoreIdColumn]) ? trim($this->attributes[$restoreIdColumn]) : null);

        return $initDetails;
    }

    /**
     * Get the Freshchat Widget Init Details.
     *
     * @return array
     */
    public function getFreshchatWidgetInitDetails(): array
    {
        $initDetails = array();

        $initDetails['token'] = config('laravel-freshchat.token');
        $initDetails['host'] = config('laravel-freshchat.host');

        return $initDetails;
    }

    /**
     * Get the Freshchat User Widget Init Details.
     *
     * @return array
     */
    public function getFreshchatUserWidgetInitDetails(): array
    {
        $widgetInitDetails = $this->getFreshchatWidgetInitDetails();
        $userInitDetails = $this->getFreshchatUserInitDetails();

        return array_merge($widgetInitDetails,$userInitDetails);
    }

    /**
     * Abstract function to set Properties of Chat User
     *
     * @return array
     */
    abstract public function chatUserProperties(): array;

    /**
     * Get the Other Properties of the User.
     *
     * @return array
     */
    public function getFreshchatUserProperties(): array
    {
        $configProperties = $this->chatUserProperties();

        $userProperties = array();

        foreach ($configProperties as $propKey => $propValue) {

            $userProperties["{$propKey}"] = (isset($propValue) && isset($this->attributes[$propValue]) ? trim($this->attributes[$propValue]) : '');
        }

        return $userProperties;
    }

    /**
     * Store the Freshchat restoreId
     *
     * @param  string  $restoreId
     * @return $this
     */
    public function setFreshchatRestoreId($restoreId)
    {
        $restoreIdColumn = $this->getRestoreIdColumn();

        if(isset($restoreIdColumn) && array_key_exists($restoreIdColumn,$this->attributes)){

            $this->$restoreIdColumn = $restoreId;
            $this->save();
        }

        return $this;
    }

    /**
     * Retrieve the Freshchat RestoreId.
     *
     * @return string|null
     */
    public function getFreshchatRestoreId()
    {
        $restoreIdColumn = $this->getRestoreIdColumn();

        return (isset($restoreIdColumn) && isset($this->attributes[$restoreIdColumn]) ? trim($this->attributes[$restoreIdColumn]) : null);
    }
}
