<?php namespace BFACP\Adkats;

use BFACP\Elegant;

class Setting extends Elegant
{
    /**
     * Should model handle timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'adkats_settings';

    /**
     * Table primary key
     *
     * @var string
     */
    protected $primaryKey = 'server_id';

    /**
     * Fields not allowed to be mass assigned
     *
     * @var array
     */
    protected $fillable = ['setting_value'];

    /**
     * Date fields to convert to carbon instances
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Append custom attributes to output
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Models to be loaded automaticly
     *
     * @var array
     */
    protected $with = [];

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function server()
    {
        return $this->belongsTo('BFACP\Battlefield\Server', 'server_id');
    }

    /**
     * Quick way of selecting specific commands
     *
     * @param        $query
     * @param  array $names Command Names
     *
     * @return
     */
    public function scopeSettings($query, $names)
    {
        return $query->whereIn('setting_name', $names);
    }

    /**
     * Quick way of selecting servers
     *
     * @param              $query
     * @param  array       $ids Array of server ids
     *
     * @return
     */
    public function scopeServers($query, $ids)
    {
        return $query->whereIn('server_id', $ids);
    }

    /**
     * Convert value to correct type
     *
     * @return mixed
     */
    public function getSettingValueAttribute()
    {
        $value = $this->attributes['setting_value'];

        if (!array_key_exists('setting_name', $this->attributes) || $this->attributes['setting_name'] == 'Custom HTML Addition') {
            return $value;
        }

        switch ($this->setting_type) {
            case 'multiline':
                if (in_array($this->attributes['setting_name'], [
                    'Pre-Message List',
                    'Server Rule List',
                    'SpamBot Say List',
                    'SpamBot Yell List',
                ])) {
                    $value = rawurldecode(urldecode($value));
                }

                $valueArray = explode('|', $value);

                if (count($valueArray) == 1) {
                    return head($valueArray);
                }

                return $valueArray;
                break;

            case 'bool':
                return $value == 'True';
                break;

            case 'int':
                return (int)$value;
                break;

            case 'double':
                return (float)$value;
                break;

            default:
                return $value;
        }
    }
}
