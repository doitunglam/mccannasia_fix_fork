<div class="mb-3">
    <label class="form-label">{{ __trans($language, $key, $default) }}</label>
<div class="" style="position: relative;">
    <div id="imgList"></div>
    @if($value != "")
    <img id="{{$id}}" src="{{ env('APP_URL').$value }}" class="mx-auto h-auto w-full object-cover" alt="" style="height: 150px !important; margin: 0px 10%; width: auto"/>
    @else
    <img id="{{$id}}" src="{{ asset('assets/images/empty_img.png') }}" class="mx-auto h-auto w-full object-cover"
        alt=".." style="height: 150px !important; margin: 0px 10%; width: auto"/>
    @endif
    
</div>
<input type="hidden" name="{{ $name }}" value="{{ $value }}" />
</div>
@push('c-script')
<script>
    var {{$id}} = document.getElementById("{{$id}}");

    {{$id}}.onclick = function () {
        elementId = "ckfinder-input-single";
        CKFinder.modal({
            language: "en",
            chooseFiles: true,
            width: 1000,
            height: 600,
            onInit: function (finder) {
                finder.on("files:choose", function (evt) {
                    var file = evt.data.files.first();
                    var thumbnail = file.getUrl();
                    $('input[name="{{ $name }}"]').val(thumbnail);
                    $("#{{$id}}").attr("src", thumbnail);
                });

                finder.on("file:choose:resizedImage", function (evt) {
                    var output = document.getElementById(elementId);
                    output.value = evt.data.resizedUrl;
                });
            },
        });
    };

    

</script>
@endpush