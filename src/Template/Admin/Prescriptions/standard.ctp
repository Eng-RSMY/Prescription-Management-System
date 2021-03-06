<?php use \Cake\Core\Configure; ?>
<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">

        <?php include('page_heading.ctp'); ?>

        <?php
            $all_prescriptions=$all_prescriptions->toArray();
            if(count($all_prescriptions) > 1){
                echo'<div class="more_prescription">
                    <div class="more_prescription_inner"><b>Prescriptions: </b>';
                        $i=1;
                        foreach($all_prescriptions as $all_prescription){
                            if(count($all_prescriptions) == $i){
                                echo $this->Html->link(
                                    $all_prescription->created->format('d F Y').' ',
                                    ['action' => 'view', $all_prescription->id],
                                    ['escapeTitle' => false, 'class' => (($all_prescription->id == $this->request->params['pass'][0])?"current-item":""), 'title' => 'View Prescription']
                                );
                            }else{
                                echo $this->Html->link(
                                    $all_prescription->created->format('d F Y').', ',
                                    ['action' => 'view', $all_prescription->id],
                                    ['escapeTitle' => false, 'class' => (($all_prescription->id == $this->request->params['pass'][0])?"current-item":""), 'title' => 'View Prescription']
                                );
                            }
                            $i++;
                        }
                    echo'</div>
                </div>';
            }
        ?>

        <div class="col-md-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
            <?php echo $this->Flash->render('admin_warning'); ?>
        </div>

        <div class="cu_con_outer" id="printable_area">
            <div class="printableArea cu_con_inner">
                <div class="prescription">
                    <div class="prescription_head">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="prescription_head_con">
                                    <?php $user = $this->request->session()->read('Auth.User'); ?>
                                    <h1 class="clinic_name" style="color: #5d5d5d"> <?php echo ($user['clinic_name']) ?> </h1>
                                    <b><p> <?php echo ($user['first_name']).' '.($user['last_name']) ?> </p></b>
                                    <b><p> <?php echo ($user['specialist']) ?> </p></b>
                                    <b><p> <?php echo ($user['educational_qualification']) ?> </p></b>
                                    <b><p> <?php echo ($user['address_line1']).','.($user['address_line2']) ?> </p></b>
                                    <b><p> Call : <?php echo ($user['phone']) ?></p></b>
                                    <b><p> <?php echo ($user['website']) ?></p></b>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div style="float:right;">
                        <b>Last Visit Date : </b><?= $latest_prescription->created->format('d F Y') ?>
                    </div>
                    <h4>Patient</h4>
                    <div>
                        <b>Name : </b> <span class="patient_info"><?= ucfirst($prescription->user->first_name) ?></span>
                        <b>Age : </b> <span class="patient_info"><?= $prescription->user->age .' Years' ?></span>
                    </div>
                    <div>
                        <b>Mobile : </b> <span class="patient_info"><?= $prescription->user->phone ?></span>
                    </div>

                    <?php if($prescription->user->address_line1){?>
                        <div>
                            <b>Address : </b> <span> <?= ucfirst($prescription->user->address_line1) ?> </span>
                        </div>
                    <?php } ?>
                    <div>
                        <b>Diagnosis : </b>
                        <?php
                        foreach($prescription->diagnosis as $diagnosis ) {
                            if($diagnosis === end($prescription->diagnosis) ){
                                echo "<span>".ucfirst($diagnosis['diagnosis_list']['name'])."</span>".".";
                            }else{
                                echo "<span>".ucfirst($diagnosis['diagnosis_list']['name'])."</span>".", ";
                            }
                        }
                        ?>
                    </div>

                    <?php if($prescription->temperature){?>
                        <div>
                            <b>Temperature : </b><span><?= $prescription->temperature ?></span>
                        </div>
                    <?php } ?>

                    <?php if($prescription->blood_pressure){?>
                        <div>
                            <b>Blood Pressure : </b><span><?= ucfirst($prescription->blood_pressure) ?></span>
                        </div>
                    <?php } ?>

                    <?php if($prescription->medicines){?>
                        <div class="prescription_block">
                            <div>
                                <h4>Medicines</h4>
                                    <?php
                                        foreach ($prescription->medicines as $medicine){
                                            echo '<div>
                                                <span class="prescription_caption">'. ucfirst($medicine->name) .'</span>
                                               '.(($medicine->_joinData->rule)? '<span> : ( '.$medicine->_joinData->rule.' )</span>': "-").'
                                            </div>';
                                        }
                                    ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if($prescription->tests){?>
                        <div class="prescription_block">
                            <div>
                                <h4>Examinations</h4>
                                <?php
                                    foreach ($prescription->tests as $test){
                                        if($test === end($prescription->tests) ){
                                            echo "<span>".ucfirst($test->name)."</span>".".";
                                        }else{
                                            echo "<span>".ucfirst($test->name)."</span>".", ";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if($prescription->doctores_notes){?>
                        <div class="prescription_block">
                            <div>
                                <h4>Doctor's Note </h4>
                                <p><?= ucfirst($prescription->doctores_notes) ?></p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if($prescription->other_instructions){?>
                        <div class="prescription_block">
                            <div>
                                <h4>Other Instructions </h4>
                                <p><?= ucfirst($prescription->other_instructions) ?></p>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="prescription_footer">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="signature">
                                    <?php $user = $this->request->session()->read('Auth.User'); ?>
                                    <p><b>Signature : </b> <?php echo $user['first_name'].' '.$user['last_name'] ?> </p>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-3">
                                <div class="prescription_date">
                                    <p><b>Date : </b> <?= $prescription->created->format('d F Y'); ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--end prescription-->
            </div>
        </div>
        <input type="hidden" value="<?php echo $is_print ?>" id="is_print" name="is_print" >
    </div>
</div>