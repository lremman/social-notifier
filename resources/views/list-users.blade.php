@extends('service.app')

@section('content')
      <!-- Buttons
      ================================================== -->
      <div class="bs-docs-section">
        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h1 id="buttons">Buttons</h1>
            </div>
          </div>
        </div>

        <div class="bs-component">
          <table class="table table-striped table-hover ">
            <thead>
              <tr>
                <th>#</th>
                <th>Column heading</th>
                <th>Column heading</th>
                <th>{{ _('Соціальні мережі') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr class="info">
                <td>3</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr class="success">
                <td>4</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr class="danger">
                <td>5</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr class="warning">
                <td>6</td>
                <td>Column content</td>
                <td>Column content</td>
                <td>Column content</td>
              </tr>
              <tr class="active">
                <td>7</td>
                <td>Column content</td>
                <td>Column content</td>
                <td class="info">
                    <span class="mt-4" style="font-size: 24px; line-height: 1.5em; color: blue;">
                        
                        <i class="success fa fa-vk"></i>
                    </span>
                    <span class="inline" style="font-size: 24px; line-height: 1.5em; color: blue;">
                        
                        <i class="fa fa-facebook-official"></i>
                    </span>
                </td>
              </tr>
            </tbody>
          </table> 
        </div>
      </div>
@endsection
