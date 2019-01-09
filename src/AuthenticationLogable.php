<?php

namespace Yadahan\AuthenticationLog;

trait AuthenticationLogable
{
    /**
     * Get the entity's authentications.
     */
    public function authentications()
    {
        return $this->morphMany(AuthenticationLog::class, 'authenticatable')->latest('login_at');
    }

    /**
     * The Authentication Log notifications delivery channels.
     *
     * @return array
     */
    public function notifyAuthenticationLogVia()
    {
        return ['mail'];
    }

    public function activeAuthentications()
	{
		return $this->authentications()->whereNull( 'logout_at' );
	}

    public function historyAuthentications()
	{
		return $this->authentications()->whereNotNull( 'logout_at' );
	}

    /**
     * Get the entity's last login at.
     */
    public function lastLoginAt()
    {
        return optional($this->authentications()->first())->login_at;
    }

    /**
     * Get the entity's last login ip address.
     */
    public function lastLoginIp()
    {
        return optional($this->authentications()->first())->ip_address;
    }

    /**
     * Get the entity's previous login at.
     */
    public function previousLoginAt()
    {
        return optional($this->authentications()->skip(1)->first())->login_at;
    }
}
