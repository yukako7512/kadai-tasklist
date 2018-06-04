@extends('layouts.app')

@section('content')

 <h1>id: {{ $tasklist->id }} のタスク編集ページ</h1>
 
 　 

    {!! Form::model($tasklist, ['route' => ['tasklists.update', $tasklist->id], 'method' => 'put']) !!}
        {!! Form::label('content', 'タスク:') !!}
        {!! Form::text('content', null, ['class' => 'form-control']) !!}
        
        {!! Form::label('status', 'ステータス:') !!}
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
        

        {!! Form::submit('更新', ['class' => 'btn btn-default']) !!}

    {!! Form::close() !!}

@endsection