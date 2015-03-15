@extends('templates.app')

@section('content')
    <table class="table table-condensed table-striped table-hover">
        <tr>
            <th>Sender</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        @foreach($inbox as $cont)
            <tr>
                <td>{{ $cont->number }}</td>
                <td>{{ $cont->text }}</td>
                <td><small>{{ date('m-d-y g:i a', strtotime($cont->insertdate)) }}</small></td>
            </tr>
        @endforeach
    </table>

    {!! $inbox->render() !!}
@stop
