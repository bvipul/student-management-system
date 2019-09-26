<?php

namespace App\Repositories;

use App\User;

class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @var User Model
     */
    protected $model;

    /**
     * @param RoleRepository $role
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin('courses', 'courses.id', '=', 'users.course_id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.is_admin',
                'courses.name as courseName',
                'users.updated_at',
                'users.created_at'
            ])->where('is_admin', '<>', 1);
    }     

    public function getStudents($course) {
        return $this->query()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.course_id',
                'users.updated_at',
                'users.created_at'
            ])->where('course_id', $course)->get();
    }
    
    public function create($input)
    {
        $input['password'] = bcrypt($input['password']);
        if(User::create($input))
        {
            return true;
        }
    }

    public function update($user, $input)
    {
        $input['password'] = bcrypt($input['password']); 
        if($user->update($input))
        {
            return true;
        }
    }

    public function delete($user)
    {
        if($user->delete())
        {
            return true;
        }
    }
}