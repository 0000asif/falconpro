<?php

    use Illuminate\Support\Facades\Auth;

    function getuser()
    {

        $user = Auth::user();
        if ($user->client) {
            $companyId = $user->client->company_id;
        } elseif ($user->vendor) {
            $companyId = $user->vendor->company_id;
        }else{
            $companyId  = '';
        }

        return $companyId;
    }
