<div class="p-3" id="{{$id}}">
    <label for="{{$id}}" class="form-label">{{ $key }}</label>
    <div class="imgArrList" class="grid grid-cols-2">
        @if($value != null)
        @foreach($value as $data)
        <img id="img_arr_prev" style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;" src="{{ env('APP_URL').$data }}" class="mx-auto h-auto w-full object-cover"
            alt="" />
        <input type="hidden" name="{{ $name }}" value="{{$data }}" />
        @endforeach
        @else
        <img class="array_prev_empty" style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;" src="{{ asset('assets/images/empty_img.png') }}"
            class="mx-auto h-auto w-full object-cover" alt=".." />
        @endif
    </div>
    <div>
        <button class="array_add_click btn btn-primary waves-effect waves-light" type="button"
            class="array_add text-text mt-3 block w-full rounded-lg bg-primary px-[21px] py-[11px] text-center text-sm font-medium">
            Upload image
        </button>
        <button class="resetArrImage btn btn-danger waves-effect waves-light" type="button"
            class="array_add text-text mt-3 block w-full rounded-lg bg-primary px-[21px] py-[11px] text-center text-sm font-medium">
            Reset
        </button>
    </div>
</div>

@push('c-script')
<script>
    $('#{{$id}} .resetArrImage').on('click', function () {
        $('#{{$id}} .imgArrList').empty();
        $('#{{$id}} .imgArrList').append(`<img class="array_prev_empty" style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;" src="{{ asset('assets/images/empty_img.png') }}" class="mx-auto h-auto w-full object-cover" alt=".." />`);
    });

    var array_add = $("#{{$id}} .array_add_click");
    $("#{{$id}} .array_add_click").click(function(){
       
        CKFinder.modal({
            language: "en",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on("files:choose", function (evt) {
                    var arr_file = evt.data.files.first();
                    var img_arr = arr_file.getUrl();
                    var datas = evt.data.files;
                    $('#{{$id}} .array_prev_empty').remove();
                    datas.map(e => {
                        $('#{{$id}} .imgArrList').append(`<input type="hidden" name="{{ $name }}" value="${e.getUrl()}" /><img style="height: 150px !important; width: auto;margin: 20px;margin-left: 20px !important;" id="img_arr_prev" src="{{env('APP_URL')}}${e.getUrl()}" class="mx-auto h-auto w-full object-cover" alt="" />`);
                    })
                });

                finder.on("file:choose:resizedImage", function (evt) {
                    var output = document.getElementById(elementId);
                    output.value = evt.data.resizedUrl;
                });
            }
        });
        
    });
    
</script>
@endpush