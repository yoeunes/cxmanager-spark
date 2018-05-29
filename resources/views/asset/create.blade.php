@extends('adminlte::page')

@section('title', 'Cx MNGR')

@section('content_header')
      <h1>
        {{ $project->project_title }} - Asset: 
        <small>{{ $pagetitle }}</small>       
      </h1>
      <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/asset">Assets</a></li>
        <li class="active">{{ $pagetitle }}</li>
      </ol>
@stop

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
          <!-- Main Content (middle panel) -->
          <div class="col-md-11">            
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">New Asset</h3> 
              </div>
              <div class="panel-body">
  
                  @include('spark::shared.errors')
                 
                  <form class="form-horizontal" method="POST" action="/asset">
                  {{ csrf_field() }}

                      <div class="form-group">
                      <label for="asset_number" class="col-sm-2 control-label">Asset Number</label>
                          <div class="col-sm-10">
                      <input type="number" name="asset_number" class="form-control" id="asset_number" placeholder="Asset Number" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="asset_title" class="col-sm-2 control-label">Asset Title</label>
                          <div class="col-sm-10">
                      <input type="text" name="asset_title" class="form-control" id="asset_title" placeholder="Asset Title" ></input>
                      </div>
                      </div>

                      <div class="form-group">
                      <label for="asset_tag" class="col-sm-2 control-label">Asset Tag</label>
                        <div class="col-sm-10">
                          <input type="text" name="asset_tag" class="form-control" id="asset_tag" placeholder="Asset Tag" ></input>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="asset_type" class="col-sm-2 control-label">Asset Type</label>
                        <div class="col-sm-10">
                          <select class="field" name="asset_type" id="asset_type">
                          @foreach ($assettypes as $assettype)
                            <option value="{{ $assettype->type_name }}">{{ $assettype->type_name }}</option>
                          @endforeach
                          </select>
                        </div>
                        
                      </div>

                      <div class="form-group">
                        <label for="include_fpt" class="col-sm-2 control-label">Include FPTs</label>
                        <div class="col-sm-10">
                          <input type="checkbox" name="include_fpt" id="include_fpt" value="1"></input>
                        </div>                        
                      </div>
                      
                      <div class="form-group">
                      <label for="asset_notes" class="col-sm-2 control-label">Notes</label>
                          <div class="col-sm-10">
                      <textarea name="asset_notes" class="form-control" id="asset_notes" placeholder="Notes" ></textarea>
                      </div>
                      </div>

                      <hr>

                      <div class="form-group">
                      <label for="asset_notes" class="col-sm-2 control-label">Additional Tags</label>
                          <div class="col-sm-10">
                      <textarea name="additional_tags" class="form-control" id="additional_tags" placeholder="for additional tags enter tags separated by comma" ></textarea>
                      </div>
                      </div>

                      <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                      <a class="btn btn-danger btn-sm" href="/asset">Cancel</a>
                      <button type="submit" class="btn btn-primary pull-right">Create Asset</button>
                      </div>
                      </div>

                  </form>

              </div>
            </div>
         </div>
        <!-- Main Content (middle panel) End -->


        <!-- Right Info Panel -->

        <!-- Right Info Panel End -->

      </div>
    </div>
</home>
@endsection


@section('adminlte_js')
    <script>
      $(document).ready(function() {
          $('#checklisttable').DataTable();
      } );
    </script>
@endsection

@section('footer')
  @include('adminlte::partials.footer')
@endsection