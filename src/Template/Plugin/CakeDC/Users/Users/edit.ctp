<div class="row">
    <div class="col-xs-12">
        <?= $this->Form->create($Users) ?>
        <fieldset>
            <legend><?= __('Edit User') ?></legend>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">&nbsp;</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $this->Form->input('username'); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $this->Form->input('email'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $this->Form->input('first_name'); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $this->Form->input('last_name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $this->Form->input('token'); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $this->Form->input('token_expires'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $this->Form->input('api_token'); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $this->Form->input('activation_date'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= $this->Form->input('tos_date'); ?>
                            </div>
                            <div class="col-xs-6">
                                <?= $this->Form->input('active'); ?>
                            </div>
                        </div>
                    </div>
                </div>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
