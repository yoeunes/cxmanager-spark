<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Energy Management Consulting, LLC.',
        'product' => 'Building Systems Commissioning',
        'street' => '5787 Avonley Creek Drive',
        'location' => 'Sugar Hill, GA 30518',
        'phone' => '678-618-1785',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'ngray@energymanagementconsulting.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'ngray@energymanagementconsulting.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront()->teamTrialDays(10);

        // Spark::noAdditionalTeams();

        Spark::useRoles([
            'member' => 'Member',
            'vip' => 'VIP',
            'cxa' => 'CxA',
            'client' => 'Client',
            'architect' => 'Architect',
            'engineer' => 'Engineer',
            'general' => 'General Contractor',
            'mechanical' => 'Mechanical Contractor',
            'electrical' => 'Electrical Contractor',
            'plumbing' => 'Plumbing Contractor',
            'controls' => 'Controls Contractor',
            'tab' => 'Test and Balance Contractor'
        ]);

        Spark::freeTeamPlan()
            ->maxTeams(1)
            ->maxTeamMembers(5)
            ->features([
                '1 Project', '5 Users', '10 Assets', '25 Checklists', '50 Issues', '2 Functional Tests', 'No Tasks', 'No Schedules', 'No Reports', 'No Events'
            ]);

        Spark::teamPlan('Standard', 'cxmngr-standard-plan-1')
            ->price(84.99)
            ->maxTeams(5)
            ->maxTeamMembers(20)
            ->features([
                '1 Project', '20 Users', '250 Assets', '2,500 Checklists', '2,500 Issues', '250 Functional Tests', 'Reports', 'No Task Management', 'No Schedule Management', 'No Event Management'
            ]);

        Spark::teamPlan('Pro', 'cxmngr-pro-plan-1')
            ->price(99.99)
            ->maxTeams(5)
            ->maxTeamMembers(30)
            ->features([
                '1 Project', '30 Users', '500 Assets', '5,000 Checklists', '5,000 Issues', '500 Functional Tests', 'Reports', 'Task Management', 'Schedule Management', 'Event Management'
            ]);
    }
}
