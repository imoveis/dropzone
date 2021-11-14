<!DOCTYPE html>
<html lang="pt-BR">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Bootstrap 101 Template</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- dropzone -->
      <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
      <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
      <!-- dropzone -->
      <style>
         .dropzone {
         background: white;
         border-radius: 5px;
         border: 2px dashed #c6c6c6;
         border-image: none;
         margin-left: auto;
         margin-right: auto;
         }
      </style>
   </head>
   <body>
      <div class="container" style="padding-top: 6em">
         <div class="row">
            <form role="form" class="multisteps-form__form" action="{{ route('properties.update',$property->id) }}" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <div class="form-group">
                  <label>Id do imóvel</label>
                  <input type="text" class="form-control" name="id" value="{{$property->id}}">
               </div>
               <div class="form-group">
                  <label>Id do imóvel</label>
                  <input type="text" class="form-control" name="imbmaster" value="9999">
               </div>
               <div class="form-group">
                  <div class="dropzone" id="myDropzone">
                     <div class="dz-message" data-dz-message>
                        <span>
                           <h2>Solte os arquivos aqui para fazer o upload</h2>
                        </span>
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary" id="submit-all">Subir imagens</button>
               <button type="submit" class="btn btn-success">Atualizar imóvel</button>
            </form>
         </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script>
         Dropzone.options.myDropzone = {
            url: '{{route('medias.store')}}',
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 1,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictRemoveFile: 'Excluir foto',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            removedfile: function (file) {
               file.previewElement.remove()
               var name = ''
               if (typeof file.id !== 'undefined') {
                  name = file.id
               } else {
                  name = uploadedDocumentMap[file.name]
               }
               $('form').find('input[name="imagens[]"][value="' + name + '"]').remove()
               
            },
            init: function() {
               var files =
               {!! json_encode(\App\mdlImagem::where('IMB_IMV_ID', $property->id)->get()->map(function ($name) {
                     return [
                        'id'        => $name->IMB_IMG_ID,
                        'imb_id'    => $name->IMB_IMB_ID,
                        'name'      => $name->IMB_IMG_ARQUIVO,
                        'file_name' => $name->IMB_IMG_ARQUIVO,
                        'mime_type' => $name->IMB_IMV_ID,
                        'imovel'    => $name->IMB_IMV_ID
                     ];
                  })) !!}
                  for (var i in files) {
                  var file = files[i]
                  this.options.addedfile.call(this, file)
                  this.options.thumbnail.call(this, file, '../../storage/images/' + file.imb_id + '/imoveis/' + file.imovel + '/' + file.file_name + '');
                  file.previewElement.classList.add('dz-complete')
                  $('form').append('<input type="hidden" name="imagens[]" value="' + file.id + '">')
                  //$('img[alt="' + file.name + '"]').before('<input type="hidden" name="order[]" value="' + file.id + '">')
               }

               dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
               // for Dropzone to process the queue (instead of default form behavior):
               document.getElementById("submit-all").addEventListener("click", function(e) {
                     // Make sure that the form isn't actually being sent.
                     e.preventDefault();
                     e.stopPropagation();
                     dzClosure.processQueue();
               });

               //send all the form data along with the files:
               this.on("sendingmultiple", function(data, xhr, formData) {
                  formData.append("id", jQuery("input[name=id]").val());
                  formData.append("imbmaster", jQuery("input[name=imbmaster]").val());
               });
            }
         }
      </script>
   </body>
</html>