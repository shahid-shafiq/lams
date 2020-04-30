<div class="container-block">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                {!! Form::open(['url' => 'submit-form']) !!}

                    <div id="gender" class="form-group">
                        <label>Please select gender</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="gender-m" name="gender" class="custom-control-input" value="male">
                            <label class="custom-control-label" for="gender-m">Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="gender-f" name="gender" class="custom-control-input" value="female">
                            <label class="custom-control-label" for="gender-f">Female</label>
                        </div>
                    </div>

                    <div id="email-cntr" class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="emailaddress" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" name="street" id="street" placeholder="Street">
                    </div>

                    <div class="form-group">
                        <label for="housenumber">Housenumber</label>
                        <input type="text" class="form-control" id="housenumber" name="housenumber" placeholder="Housenumber">
                    </div>

                    <div class="form-group">
                        <label for="addition">Housenumber addition</label>
                        <input type="text" class="form-control" id="addition" name="housenumber_addition" placeholder="Housenumber addition">
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Zipcode</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode">
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>

                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" id="country" name="country">
                            <option value="nl">Netherlands</option>
                            <option value="be">Belgium</option>
                            <option value="de">Germany</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>