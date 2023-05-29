<?php

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Jobs = [
            [
                'id'                    =>  1,
                'user_id'               =>  1,
                'job_type_id'           =>  1,
                'department_id'         =>  1,
                'designation_id'        =>  2,
                'title'                 =>  'Combustion Lead Engineer',
                'jobid'                 =>  'CMB-100178-G-K003-10-0001',
                'description'           =>  '<p><strong>Essential Functions</strong></p>

<p>Perform the design engineering work of Department related scope for the concerned project by preparing the Department Project Execution Plan, providing instructions to each Engineer, verifying design outputs by the Engineers, coordinate with other parties to ensure that the project is completed as per the objectives, the contracts in line with the engineering department&rsquo;s strategy and objectives as well as JGC Gulf initiative while ensuring safety.</p>

<p><strong>Engineering Operations Management</strong></p>

<ul>
    <li>Review and approve the work assignment plan, design engineering scheduling and monitoring plan developed</li>
    <li>Lead the engineering team and hold responsibilities for the decisions on the engineering designs, authorities and projects</li>
    <li>Oversee the progress of all projects to ensure effective engineering team execution of the different phases .</li>
    <li>Lead project teams whenever needed to ensure the resolution of discipline issues in a timely and effective.</li>
    <li>Verify and manage contractual requirement and design inputs for design work.</li>
    <li>Assign responsible design work like deliverable and activities to each Engineer and distribute necessary information</li>
    <li>Guide the engineering team and help make decisions on the engineering designs, authorities and projects in a timely and effectively to be completed to ensure the design output will meet project and JGC Gulf set objectives.</li>
    <li>Coordination with other disciplines, client, vendors and engineering subcontractors to ensure design engineering work and output will meet the project objectives.</li>
    <li>Guide the engineering team to prepare material requisition to vendor, evaluating vendor proposal technically and selecting vendor, verifying vendor&rsquo;s document and inspecting engineered equipment by vendors.</li>
    <li>Guide the engineering team to prepare BQ (Bill of Material), support construction department for evaluating construction subcontractor, execute Field Engineering, loop test and function test at Project site.</li>
</ul>

<p><strong>Project&nbsp;</strong><strong>Management</strong></p>

<ul>
    <li>Lead and control the progress of the engineering projects, approved budgeted costs, quality, timelines, standard of the contractors in order to ensure that project objectives are met in line with approved parameters.</li>
    <li>Prepare Project Execution plan including, design engineering schedule, deliverable list with target date, Audit plan, Man Power mobilization plan, procurement strategy, cost down idea, risk identification &amp; countermeasure plan to align project, JGC Gulf and department objectives.</li>
    <li>Planning, evaluating and Selecting Engineering Subcontractor use</li>
    <li>Direct and report the progress of the projects, approved Man Hour, BM (Bill of Material) for the procurement, BQ (Bill of Quality) for Construction Work, timelines, in order to ensure that project objectives are met in line with approved parameters. report the managerial concerns of the project such as the discipline budget and its allocation to ensure project execution within the required time to the Engineering Department Manager.</li>
</ul>

<p><strong>Desirable Skills</strong></p>

<ul>
    <li>Candidate must have experience of handling water treatment packages for refinery applications such as Oily Water Treatment Packages, Sanitary Treatment Packages, RO Packages, Sludge handling packages etc.</li>
</ul>

<p><strong>Basic&nbsp;</strong><strong>Job Requirements</strong></p>

<ul>
    <li>Bachelor&rsquo;s degree in Mechanical Engineering</li>
    <li>12 to 15 years&rsquo; planning and scheduling experience in EPC projects. Leadership, problem solving in PJs, knowledge of Quality Management System</li>
    <li>To be assigned in Al-Khobar office &amp; at the same time must be willing to be assigned in domestic and/or overseas projects sites.</li>
    <li>Candidates within KSA and with transferable iqama will be preferred.</li>
</ul>',
                'no_of_vacancy'         =>  3,
                'minimum_exp_req'       =>  5,
                'minimum_qualification' =>  'Graduate',
                'location_id'           =>  1,
                'salary'                =>  '5000',
                'location_preference'   =>  ["1"],
                'gender_preference'     =>  'Male',
                'attachment'            =>  '',
                'approved_by'           =>  2,
                'status'                =>  0,
                'created_at'            => date("Y-m-d h:i:s"),
                'updated_at'            => date("Y-m-d h:i:s"),
            ],
            [
                'id'                    =>  2,
                'user_id'               =>  1,
                'job_type_id'           =>  2,
                'department_id'         =>  2,
                'designation_id'        =>  2,
                'title'                 =>  'Schedule Control Engineer',
                'jobid'                 =>  'CMB-100178-G-K003-10-0002',
                'description'           =>  '<p><strong>Essential Functions</strong></p>

<p>Perform the design engineering work of Department related scope for the concerned project by preparing the Department Project Execution Plan, providing instructions to each Engineer, verifying design outputs by the Engineers, coordinate with other parties to ensure that the project is completed as per the objectives, the contracts in line with the engineering department&rsquo;s strategy and objectives as well as JGC Gulf initiative while ensuring safety.</p>

<p><strong>Engineering Operations Management</strong></p>

<ul>
    <li>Review and approve the work assignment plan, design engineering scheduling and monitoring plan developed</li>
    <li>Lead the engineering team and hold responsibilities for the decisions on the engineering designs, authorities and projects</li>
    <li>Oversee the progress of all projects to ensure effective engineering team execution of the different phases .</li>
    <li>Lead project teams whenever needed to ensure the resolution of discipline issues in a timely and effective.</li>
    <li>Verify and manage contractual requirement and design inputs for design work.</li>
    <li>Assign responsible design work like deliverable and activities to each Engineer and distribute necessary information</li>
    <li>Guide the engineering team and help make decisions on the engineering designs, authorities and projects in a timely and effectively to be completed to ensure the design output will meet project and JGC Gulf set objectives.</li>
    <li>Coordination with other disciplines, client, vendors and engineering subcontractors to ensure design engineering work and output will meet the project objectives.</li>
    <li>Guide the engineering team to prepare material requisition to vendor, evaluating vendor proposal technically and selecting vendor, verifying vendor&rsquo;s document and inspecting engineered equipment by vendors.</li>
    <li>Guide the engineering team to prepare BQ (Bill of Material), support construction department for evaluating construction subcontractor, execute Field Engineering, loop test and function test at Project site.</li>
</ul>

<p><strong>Project&nbsp;</strong><strong>Management</strong></p>

<ul>
    <li>Lead and control the progress of the engineering projects, approved budgeted costs, quality, timelines, standard of the contractors in order to ensure that project objectives are met in line with approved parameters.</li>
    <li>Prepare Project Execution plan including, design engineering schedule, deliverable list with target date, Audit plan, Man Power mobilization plan, procurement strategy, cost down idea, risk identification &amp; countermeasure plan to align project, JGC Gulf and department objectives.</li>
    <li>Planning, evaluating and Selecting Engineering Subcontractor use</li>
    <li>Direct and report the progress of the projects, approved Man Hour, BM (Bill of Material) for the procurement, BQ (Bill of Quality) for Construction Work, timelines, in order to ensure that project objectives are met in line with approved parameters. report the managerial concerns of the project such as the discipline budget and its allocation to ensure project execution within the required time to the Engineering Department Manager.</li>
</ul>

<p><strong>Desirable Skills</strong></p>

<ul>
    <li>Candidate must have experience of handling water treatment packages for refinery applications such as Oily Water Treatment Packages, Sanitary Treatment Packages, RO Packages, Sludge handling packages etc.</li>
</ul>',
                'no_of_vacancy'         =>  10,
                'minimum_exp_req'       =>  6,
                'minimum_qualification' =>  'Post Graduate',
                'location_id'           =>  1,
                'salary'                =>  '10000',
                'location_preference'   =>  ["1"],
                'gender_preference'     =>  'Male',
                'attachment'            =>  '',
                'approved_by'           =>  2,
                'status'                =>  0,
                'created_at'            => date("Y-m-d h:i:s"),
                'updated_at'            => date("Y-m-d h:i:s"),
            ],
              
        ];
        Job::insert($Jobs);
    }
}
