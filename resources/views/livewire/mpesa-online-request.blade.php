<div>

    @if(!empty($successMessage))
    <div class="alert alert-success">
        {{ $successMessage }}
    </div>
    @endif

    <form wire:submit.prevent="submit" action="POST">
        <div class="row col-12">
            <div class="form-group col-6">
                <label for="phone_number">Phone number</label>
                <input type="text" class="form-control" id="phone_number" placeholder="Enter phone number"
                    wire:model="phone_number">
                @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-6">
                <label for="amount">amount</label>
                <input type="number" class="form-control" id="amount" placeholder="Enter the amount"
                    wire:model="amount">
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="row offset-9">
            <button type="submit" class="btn btn-primary btn-sm">Initiate payment</button>
        </div>
    </form>
</div>
