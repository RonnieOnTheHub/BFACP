<?php namespace BFACP\Battlefield;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model AS Eloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use MainHelper;
use BattlefieldHelper;

class Server extends Eloquent
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'tbl_server';

    /**
     * Table primary key
     * @var string
     */
    protected $primaryKey = 'ServerID';

    /**
     * Fields not allowed to be mass assigned
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * Date fields to convert to carbon instances
     * @var array
     */
    protected $dates = [];

    /**
     * Should model handle timestamps
     *
     * @var boolean
     */
    public $timestamps = FALSE;

    /**
     * Append custom attributes to output
     * @var array
     */
    protected $appends = ['percentage', 'ip', 'port', 'server_name_short', 'in_queue', 'maps_file_path', 'modes_file_path', 'squads_file_path', 'teams_file_path', 'current_map', 'current_gamemode'];

    /**
     * The attributes excluded form the models JSON response.
     * @var array
     */
    protected $hidden = ['maps_file_path', 'modes_file_path', 'squads_file_path', 'teams_file_path'];

    /**
     * Models to be loaded automaticly
     * @var array
     */
    protected $with = ['game', 'setting'];

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function game()
    {
        return $this->belongsTo('BFACP\Battlefield\Game', 'GameID')->remember(10);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scoreboard()
    {
        return $this->hasMany('BFACP\Battlefield\Scoreboard\Scoreboard', 'ServerID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setting()
    {
        return $this->hasOne('BFACP\Battlefield\Setting', 'server_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scores()
    {
        return $this->hasMany('BFACP\Battlefield\Scoreboard\Scores', 'ServerID');
    }

    /**
     * Only return servers that should be active
     */
    public function scopeActive($query)
    {
        return $query->where('ConnectionState', 'on');
    }

    /**
     * Returns the server name with the strings that are
     * to be removed from it.
     * @return string/null
     */
    public function getServerNameShortAttribute()
    {
        if( empty($this->setting->name_strip) )
            return NULL;

        $strings = explode(',', $this->setting->name_strip);

        return preg_replace('/\s+/', ' ',  trim( str_replace($strings, NULL, $this->ServerName) ) );
    }

    /**
     * Calculates how full the server is represented by a percentage
     * @return float
     */
    public function getPercentageAttribute()
    {
        return MainHelper::percent($this->usedSlots, $this->maxSlots);
    }

    /**
     * Gets the IP Address
     * @return string
     */
    public function getIPAttribute()
    {
        $host = explode(":", $this->IP_Address)[0];
        return gethostbyname($host);
    }

    /**
     * Gets the RCON port from the IP Address
     * @return integer
     */
    public function getPortAttribute()
    {
        $port = explode(":", $this->IP_Address)[1];
        return (int) $port;
    }

    /**
     * Gets the human readable name of the current map
     * @return string
     */
    public function getCurrentMapAttribute()
    {
        return BattlefieldHelper::mapName($this->mapName, $this->maps_file_path);
    }

    /**
     * Gets the human readable name of the current mode
     * @return string
     */
    public function getCurrentGamemodeAttribute()
    {
        return BattlefieldHelper::playmodeName($this->Gamemode, $this->modes_file_path);
    }

    /**
     * Gets the number of players currently in queue and caches the result for 5 minutes
     * @return integer
     */
    public function getInQueueAttribute()
    {
        $result = Cache::remember('server.' . $this->ServerID . '.queue', 5, function()
        {
            $battlelog = App::make('BFACP\Libraries\Battlelog\BattlelogServer');

            return $battlelog->server($this)->inQueue();
        });

        return $result;
    }

    /**
     * Gets the path of the maps xml file
     * @return string
     */
    public function getMapsFilePathAttribute()
    {
        $path = app_path() .
            DIRECTORY_SEPARATOR . 'bfacp' .
            DIRECTORY_SEPARATOR . 'ThirdParty' .
            DIRECTORY_SEPARATOR . strtoupper($this->game->Name) .
            DIRECTORY_SEPARATOR . 'mapNames.xml';
        return $path;
    }

    /**
     * Gets the path of the gamemodes xml file
     * @return string
     */
    public function getModesFilePathAttribute()
    {
        $path = app_path() .
            DIRECTORY_SEPARATOR . 'bfacp' .
            DIRECTORY_SEPARATOR . 'ThirdParty' .
            DIRECTORY_SEPARATOR . strtoupper($this->game->Name) .
            DIRECTORY_SEPARATOR . 'playModes.xml';
        return $path;
    }

    /**
     * Gets the path of the squads xml file
     * @return string
     */
    public function getSquadsFilePathAttribute()
    {
        $path = app_path() .
            DIRECTORY_SEPARATOR . 'bfacp' .
            DIRECTORY_SEPARATOR . 'ThirdParty' .
            DIRECTORY_SEPARATOR . strtoupper($this->game->Name) .
            DIRECTORY_SEPARATOR . 'squadNames.xml';
        return $path;
    }

    /**
     * Gets the path of the teams xml file
     * @return string
     */
    public function getTeamsFilePathAttribute()
    {
        $path = app_path() .
            DIRECTORY_SEPARATOR . 'bfacp' .
            DIRECTORY_SEPARATOR . 'ThirdParty' .
            DIRECTORY_SEPARATOR . strtoupper($this->game->Name) .
            DIRECTORY_SEPARATOR . 'teamNames.xml';
        return $path;
    }
}
