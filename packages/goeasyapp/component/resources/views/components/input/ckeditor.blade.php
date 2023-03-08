
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{ __trans($language, $key, $default) }}</label>
<textarea name="{{ $name }}" id="ckeditor_{{ $name }}" rows="10" cols="80">
    {!! $value !!}
</textarea>
</div>
@push('c-script')
<script>
	var key = "ckeditor_"+"{{ $name }}";
    var editor = CKEDITOR.replace(key, {
		toolbarGroups: [
			{"name":"basicstyles","groups":["basicstyles"]},
			{"name":"links","groups":["links"]},
			{"name":"paragraph","groups":["list","blocks"]},
			{"name":"document","groups":["mode"]},
			{"name":"insert","groups":["insert"]},
			{"name":"styles","groups":["styles"]},
			{"name":"about","groups":["about"]}
		],
		emoveButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
	});
	CKFinder.setupCKEditor(editor);
</script>
@endpush