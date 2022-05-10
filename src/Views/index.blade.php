
@extends('layout')

@section('content')
    <div class="container">
        <div class="panel panel-warning">
            <div class="panel-heading"><h2>Thống kê</h2></div>
        <div class="panel-body">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">DEV</th>
                    <th scope="col">Tổng điểm</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td class="birthday">{{$user->birthday}}</td>
                            <td>{{$user->dev}}</td>
                            <td>{{$user->id}}</td>
                        </tr>
                    @endforeach
                 
                </tbody>
              </table>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="panel panel-warning">
            <div class="panel-heading"><h2>Load json to server</h2></div>
        <div class="panel-body">
            <div class="fom-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="dev">Dev</label>
                        <input type="text" class="form-control" id="dev" value="Dev2">
                    </div>
                    <div class="col-md-3">
                        <label for="date">Date exam</label>
                        <input type="text" class="form-control" id="date" value="9/10/2019">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success"  id="load">Load</button>
                    </div>
                    <div class="col-md-3">
                        <a href="@Route({"name": "abb", "id" : "1012", "c_id" : "99"})">Thưởng nhân viên</a>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Birthday</th>
                    <th scope="col">DEV</th>
                    <th scope="col">Tổng điểm</th>
                  </tr>
                </thead>
                <tbody id="body_load">
                    
                 
                </tbody>
              </table>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        let date = $('.birthday')
        for(let i=0; i<date.length;i++){
            if(moment($(date).eq(i).text(), 'MM/DD/YYYY',true).isValid()){
                $(date).eq(i).html($(date).eq(i).text()+' <p style="color:blue">Đúng định dạng mm/dd/yyyy</p>')
            }else{
                $(date).eq(i).html($(date).eq(i).text()+' <p style="color:red">Sai định dạng mm/dd/yyyy</p>')
            }
        }

        $('#load').on('click', function(e){
            e.preventDefault()
            let dev = $('#dev').val() == '' ? 'dev' : $('#dev').val()
            let date_exam = $('#date').val() == '' ? 'date_exam' : $('#date').val()
            $.ajax({
                url: '@Route({"name": "search"})',
                type: 'POST',
                data: {
                    dev: dev,
                    date_exam : date_exam
                }
            }).done(resp => {

                if(resp == []){
                    alert('Không có dữ liệu')
                }else{
                    $.each(resp, function(index,item){
                        let tmp = `
                        <tr>
                            <th scope="row">${item.original.id}</th>
                            <td>${item.original.name}</td>
                            <td class="birthday">${item.birthday} 
                                ${moment(item.original.birthday, 'MM/DD/YYYY',true).isValid() ? '<p style="color:blue">Đúng định dạng mm/dd/yyyy</p>': '<p style="color:red">Sai định dạng mm/dd/yyyy</p>'}
                                </td>
                            <td>${item.original.dev}</td>
                            <td>${item.original.point}</td>
                        </tr>`;
                        $('#body_load').append(tmp);
                    })
                }

            }).fail(e => {

            })
        })
        

    })
</script>
@endsection