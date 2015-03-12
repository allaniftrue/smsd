@extends('templates.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(( Session::get('message') ))
                {!! Session::get('message') !!}
            @endif
        </div>
        <div class="col-md-6">
            <form action="{{ url('contacts/store') }}" method="POST" class="form-inline" id="form-save-contact">
                <div class="form-group">
                    <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" placeholder="example: 09275632103" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="example: Allan" required>
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" class="btn btn-primary" id="btn-save" data-loading-text="Saving contact...">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Save Contact
                </button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ url('contacts/search') }}" class="form-inline sm-margin-top-20" id="form-search-contact">
                <div class="form-group">
                    <input type="text" class="form-control" id="kw" name="kw" placeholder="example: 09275632103" required>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-save" data-loading-text="Searching contact list">
                    <i class="glyphicon glyphicon-search"></i> Search
                </button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <a href="{{ url('contacts') }}" class="btn btn-default" id="btn-reset" data-loading-text="Searching contact list...">
                    <i class="glyphicon glyphicon-refresh"></i> Reset
                </a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-condensed table-hover table-bordered margin-top-20">
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th></th>
                </tr>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->number }}</td>
                    <td class="actions">
                        <a href="{{ url('contacts/send/') }}/{{ $contact->number}}">
                            <i class="glyphicon glyphicon-send"></i>
                        </a>
                        <a href="javascript:void(0);" id="remove" data-id="{{ $contact->id }}">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $contacts->render() !!}
        </div>
    </div>
@stop

@section('jsFooter')
<script>
    (function(){
        $('#form-save-contact,#form-search-contact').on("submit", function(){
            $(this).children('button').button('loading');
        });

        $('#btn-reset').click(function(){
            $(this).button('loading');
        });

        $('[id=remove]').click(function(e){

            e.preventDefault();
            var $this = $(this);



            $.ajax({
                type: 'post',
                url: 'contacts/destroy',
                data: {
                    id: $this.data('id'),
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(r) {
                    if(r.status == 1) {
                        $this.closest('tr').fadeOut('slow');
                    } else {
                        alert('unable to to remove contact');
                    }
                },
                error: function(){
                    alert("unable to process request");
                }
            });
        });

    })();
</script>
@stop
