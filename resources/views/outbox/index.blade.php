@extends('templates.app')

@section('content')
    <table class="table table-condensed table-striped table-hover">
        <tr>
            <th class="hidden-xs">Sender</th>
            <th>Message</th>
            <th class="hidden-xs">Date</th>
        </tr>
        @foreach($outbox as $cont)
            <tr>
                <td class="hidden-xs">
                    {{ $cont->name or $cont->outboxNumber }}
                </td>
                <td>
                    <span class="visible-xs"><strong>{{ $cont->name or $cont->outboxNumber }}</strong><br></span>
                    <span class="visible-xs"><small>{{ date('m-d-y g:i a', strtotime($cont->insertdate)) }}</small><br></span>
                    {{ $cont->text }}
                </td>
                <td class="hidden-xs"><small>{{ date('m-d-y g:i a', strtotime($cont->insertdate)) }}</small></td>
            </tr>
        @endforeach
    </table>

    {!! $outbox->render() !!}
@stop
