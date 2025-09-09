<div class="modal fade" id="savePlanModal" tabindex="-1" aria-labelledby="savePlanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="savePlanForm" action="{{ route('plans.save') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="savePlanLabel">Save Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modalPlanName" class="form-label">Plan Name:</label>
                        <input type="text" class="form-control" name="plan_name" id="modalPlanName" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalAreaShape" class="form-label">Area Shape:</label>
                        <input type="text" class="form-control" name="area_shape" id="modalAreaShape" required placeholder="e.g., rectangle, circle">
                    </div>
                    <input type="hidden" name="planting_system" id="modalPlantingSystem" value="square">
                    <input type="hidden" name="plant_spacing" id="modalPlantSpacing">
                    <input type="hidden" name="num_plants" id="modalNumPlants">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="modalSubmitBtn" class="btn btn-plant">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
