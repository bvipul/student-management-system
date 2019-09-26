<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;
use PDF;

class StudentController extends ApiController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->get('paginate') ? $request->get('paginate') : 25;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        if($request->get('all')) {
            return UserResource::collection(
                $this->repository->getForDataTable(1, false)->orderBy($sortBy, $orderBy)->get()
            );
        } else {
            return UserResource::collection(
                $this->repository->getForDataTable(1, false)->orderBy($sortBy, $orderBy)->paginate($limit)
            );
        }
    }

    /**
     * Return the specified resource.
     *
     * @param int $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user)
    {
        $user = User::find($user);
        return new UserResource($user);
    }

    /**
     * Create User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = $this->validateUser($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->create($request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "User Created Successfully"
        ]);
    }

    /**
     * Update User.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Validator object
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        $validation = $this->validateUser($request, 'edit', $user->id);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($user, $request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "User Updated Successfully"
        ]);
    }

    /**
     * Delete User.
     *
     * @param User    $user
     * @param Request $request
     *
     * @return mixed
     */
    public function destroy($user, Request $request)
    {
        $user = User::find($user);
        $userId = $user->id;
        $this->repository->delete($user);

        return $this->respond([
            'success'   => true,
            'data'      => $userId,
            'message'   => 'User Successfully Deleted!',
        ]);
    }

    /**
     * Delete All User.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function deleteAll(Request $request)
    {
        $ids = $request->get('ids');

        if (isset($ids) && !empty($ids)) {
            $result = $this->repository->deleteAll($ids);
        }

        if ($result) {
            return $this->respond([
                'message'   => trans('alerts.backend.users.deleted'),
            ]);
        }

        return $this->respond([
            'message'   => trans('exceptions.backend.access.users.not_found'),
        ]);
    }

    /**
     * validateUser User.
     *
     * @param $request
     * @param $action
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateUser(Request $request, $action = '', $id = 0)
    {
        $password = ($action == 'edit') ? '' : 'required|min:6';

        $validation = Validator::make($request->all(), [
            'name'            => 'required|max:255',
            'email'           => 'required|max:255|email|unique:users,email,'.$id,
            'password'        => $password,
            'course_id'          => 'required|exists:courses,id'
        ]);

        return $validation;
    }

    /**
     * getStudents
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudents(Request $request)
    {
        $course = $request->input('course');

        return $this->respond([
            'success' => true,
            'data' => $this->repository->getStudents($course)
        ]);
    }

    /**
     * downloadReport
     * @param  Request $request 
     * @param  int  $id      
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadReport(Request $request, $id) {
        $student = User::find($id);

        if($student) {
            $data = $student->marks->groupBy('semester.name');

            $pdf = PDF::loadView('report', ['data' => $data, 'course' => $student->course->name]);
  
            return $pdf->download('report.pdf');
        } else {
            return redirect()->to('/admin/student');
        }
    }

    /**
     * getSemesterMarks
     * @param  Request $request
     * @param  int  $id
     * @param  int  $semesterId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSemesterMarks(Request $request, $id, $semesterId) {
        $student = User::find($id);

        $data = $student->marks()->where('semester_id', $semesterId)->get();

        return $this->respond([
            'success' => true,
            'data' => $data
        ]);
    }
}
