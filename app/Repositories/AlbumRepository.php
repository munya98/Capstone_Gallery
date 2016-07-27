<?php 

namespace App\Repositories;

use App\User;

class AlbumRepository
{
	public function forUser(User $user){
		return $user->albums()->orderBy('created_at', 'asc')->simplePaginate(9);
	}
}