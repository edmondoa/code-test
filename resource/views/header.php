<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Task
        </button>
        </li>
       
      </ul>
      <div class="col-3">
        Complete <span class="badge bg-secondary bg-success" id='total-completed'>4</span>
      </div>
      <div class="col-3">
        Total <span class="badge bg-secondary bg-primary" id='total'>4</span>
      </div>
      <form class="d-flex">
      <div class="input-group mb-2">
          <span class="input-group-text" >Show By</span>
          <select class="form-control" id="show-by">
          <option value="">  </option>
              <option value="Complete"> Complete </option>
              <option value="Pending"> Pending </option>
          </select>
        </div>
        <div class="input-group mb-2">
          <span class="input-group-text" >Sort By</span>
          <select class="form-control" id="sort-by">
          <option value="">  </option>
              <option value="task_name"> Name </option>
              <option value="priority"> Priority </option>
          </select>
        </div>
      </form>
    </div>
  </div>
</nav>