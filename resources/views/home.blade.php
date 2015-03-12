@extends('templates.app')

@section('content')
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
    <form action="{{ url('home/send-message') }}" method="POST">
        <div class="control-group">
            <label for="select-to">To:</label>
            <select id="select-to" class="contacts" placeholder="Pick some people..."></select>
        </div>
        <div class="control-group">
            <label for="select-to">Message: <span id="charNum" class="label label-info"></span></label>
            <textarea name="message" id="message" rows="5" class="col-md-12 form-control" placeholder="Write your 150 characters message here..."></textarea>
        </div>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="number" id="number" value="{{ $numberExist or '' }}">
        <button type="submit" class=" btn btn-primary margin-top-20" id="btn-send" data-loading-text="Sending text message...">
            <i class="glyphicon glyphicon-send"></i> Send Text Message
        </button>
    </form>
@stop

@section('jsFooter')
<script>
    (function(){

        $('#message').keyup(function() {
            var max = 150;
            var len = $(this).val().length;
            var $this = $(this);
            if (len >= max) {
                $('#charNum').text(' you have reached the limit');
                $this.val($this.val().substring(0,150));
            } else {
                var char = max - len;
                $('#charNum').text(char + ' characters left');
            }
        });

        $('#select-to').selectize({
            plugins: ['restore_on_backspace'],
            persist: false,
            maxItems: 1,
            valueField: 'number',
            labelField: 'name',
            searchField: ['name', 'number'],
            options: {!! $existingContacts !!},
            create: true,
            render: {
                option: function(item, escape) {
                    var name = item.name;
                    var label = name || item.number;
                    var caption = name ? item.number : null;
                    return '<div>' +
                        '<span>' + escape(label) + '</span>' +
                        (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                    '</div>';
                },
                item: function(data, escape) {
                    return '<div>'+ data.name + ' - ' + escape(data.number) + '</div>';
                }
            },
            onChange: function(value) {
                $('#number').val(value);
            }
        });

        $('#select-to')[0].selectize.setValue(['{{ $numberExist or '' }}']);

        $('#btn-send').click(function(){
            $(this).button('loading');
        });

    })();
</script>
@stop
