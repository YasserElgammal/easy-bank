<?php

namespace App\Providers;

use App\Interfaces\{
    AuthRepositoryInterface,
    CustomerDepositRepositoryInterface,
    CustomerRepositoryInterface,
    CustomerWithdrawRepositoryInterface,
    DepositRepositoryInterface,
    EmployeeRepositoryInterface,
    PayrollRepositoryInterface,
    SettingRepositoryInterface,
    TransactionRepositoryInterface,
};
use App\Repositories\V1\Admin\{DepositRepository, EmployeeRepository, PayrollRepository, SettingRepository};
use App\Repositories\V1\Customer\{CustomerRepository, CustomerWithdrawalRepository, CutomerDepositRepository, TransactionRepository, WithdrawalRepository};
use App\Repositories\V1\AuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(CustomerWithdrawRepositoryInterface::class, CustomerWithdrawalRepository::class);
        $this->app->bind(DepositRepositoryInterface::class, DepositRepository::class);
        $this->app->bind(CustomerDepositRepositoryInterface::class, CutomerDepositRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(PayrollRepositoryInterface::class, PayrollRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }
}
