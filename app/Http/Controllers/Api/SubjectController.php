<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\SubjectRepository;
use App\Http\Resources\SubjectResource;
use Illuminate\Validation\Rule;
use Validator;

use App\Subject;

class SubjectController extends ApiController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(SubjectRepository $repository)
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
        $limit = $request->get('paginate') ? $request->get('paginate') : 100;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        return SubjectResource::collection(
            $this->repository->getForDataTable(1, false)->orderBy($sortBy, $orderBy)->paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validateSubject($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->create($request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Subject Created Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::find($id);
        return new SubjectResource($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);
        $validation = $this->validateSubject($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($subject, $request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Subject Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        $subjectId = $subject->id;
        $this->repository->delete($subject);

        return $this->respond([
            'success'   => true,
            'data'      => $subjectId,
            'message'   => 'Subject Successfully Deleted!'
        ]);
    }

    /**
     * validateSubject
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSubject(Request $request)
    {
        $rules = [
            'course_id'       => 'required',
            'semester_id'     => 'required',
            'name'            => [
                'required',
                Rule::unique('subjects')->where(function($query) use($request) {
                    return $query->where('course_id', $request->course_id)
                        ->where('semester_id', $request->semester_id)
                        ->where('name', $request->name);
                })
            ]
        ];

        $validation = Validator::make($request->all(), $rules);

        return $validation;
    }

    /**
     * getSubjects
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubjects(Request $request) {
        $course = $request->input('course');
        $semester = $request->input('semester');

        return $this->respond([
            'success' => true,
            'data' => $this->repository->getSubjects($course, $semester)
        ]);
    }
}
