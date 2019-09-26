<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Student Report</title>
 <style>
   .container{
      padding: 5%;
      text-align: center;
   }
   table {
    width: 100%;
   } 
   th,td {
    padding: 5px;
    text-align:center;
   }
</style>
</head>
<body>
  <div class="container">
      <div class="row">
          <div class="col-md-12">
            <h2>{{ $course }}</h2>
            @foreach($data as $semester => $semesterData)
              <h3>{{ $semester }}</h3>
              <table class="table" border>
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                  </tr> 
                </thead>
                <tbody>
                  @foreach($semesterData as $d)
                    <tr>
                      <td>{{ $d->subject->name }}</td>
                      <td>{{ $d->marks }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endforeach
            {{-- <table class="table table-bordered" id="laravel_crud">
              <thead>
                <tr>
                   <th>Id</th>
                   <th>Title</th>
                   <th>Description</th>
                   <th>Created at</th>
                </tr>
              </thead>
              <tbody>
                @foreach($notes as $note)
                <tr>
                   <td>{{ $note->id }}</td>
                   <td>{{ $note->title }}</td>
                   <td>{{ $note->description }}</td>
                   <td>{{ date('d m Y', strtotime($note->created_at)) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table> --}}
         </div> 
     </div>
  </div>
</body>
</html>
