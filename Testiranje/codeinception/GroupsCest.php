<?php

class GroupsCest
{
    public function _before(AcceptanceTester $I)
    {

        $I->amGoingTo("Login");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'ana');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/group/index"]');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
    }

    public function _after(AcceptanceTester $I)
    {
        $I->amGoingTo("Logout");
        $I->amOnPage('/homePage/index');
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');
    }

//    public function testUserNotLogin(AcceptanceTester $I)
//    {
//        $I->amGoingTo("Check permissions");
//        $I->amOnPage('/group/index');
//        $I->dontSee('Groups');
//        $I->amOnPage('/login');
//        $I->see('Login');
//        $I->see('Registration');
//    }

    public function testSuccessCreateGroup(AcceptanceTester $I)
    {

        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Family group one member');
        $I->click('Create Group');

        $I->see('GROUPS');
        $I->see('Family');

    }

    public function testCreateGroupFailNameIsEmpty(AcceptanceTester $I)
    {

        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', '');
        $I->fillField('description', 'Fail group create');
        $I->click('Create Group');
        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');

    }

    public function testSuccessInviteMemberNewGroup(AcceptanceTester $I)
    {
        $I->amGoingTo("Create group with member");

        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Group with Bodin');
        $I->fillField("#member", 'bodin');
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Create Group');
        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group with Bodin');
    }

    public function testFailMemberNotExist(AcceptanceTester $I)
    {
        $I->amGoingTo("Create group with member");

        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Group with Unknown');
        $I->fillField("#member", 'nepostojeci');
        $I->click('Add');
        $I->click('Create Group');

        $I->waitForElement("#infoModal");
    }

    public function removeInvitedMemberCreateNewGroup(AcceptanceTester $I)
    {
        $I->amGoingTo("Remove member from invite list");

        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Group with Bodin');
        $I->fillField("#member", 'bodin');
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Dismiss');
        $I->dontSee('@bodin');
    }

    public function testApproveRequestJoinGroup(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('description', 'Family group one member');
        $I->fillField('group_name', 'Group with Bodin');
        $I->fillField("#member", 'bodin');
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Create Group');
        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group with Bodin');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Group with Bodin');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->click('a[href="http://localhost:8080/group/index"]');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group with Bodin');
        $I->click('Info');
        $I->see('INFO');
        $I->see('2 members');
        $I->see('Ana');
        $I->see('Bodin');
    }

    public function testGiveUpCreateGroup(AcceptanceTester $I)
    {

        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Family group one member');
        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->dontSee('Family');

    }




    public function testBecomeAdminCreatedGroup(AcceptanceTester $I)
    {
        $I->dontSee('I am admin');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'I am admin');
        $I->fillField('description', 'My group');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('I am admin');

        $I->click('Info');
        $I->see('INFO');
        $I->see('1 members');
        $I->see('Ana');
        $I->seeElement(".bg-warning");
    }

    public function testInfoGroup(AcceptanceTester $I)
    {
        $I->dontSee('Group info');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Group info');
        $I->fillField('description', 'My group');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group info');

        $I->click('Info');
        $I->see('INFO');
        $I->see('1 members');
        $I->see('Ana');
        $I->seeElement(".bg-warning");
        $I->see("Monthly Spending / Monthly No Of Lists");
        $I->see("Most frequently requested YEAR / MONTH");

    }

    public function testChangeGroupInfoNoAdmin(AcceptanceTester $I)
    {
        $I->dontSee('Group with Bodin');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('description', 'Family group one member');
        $I->fillField('group_name', 'Group with Bodin');
        $I->fillField("#member", 'bodin');
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Create Group');
        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group with Bodin');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Group with Bodin');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->click('a[href="http://localhost:8080/group/index"]');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Group with Bodin');
        $I->seeElement('.btn-outline-primary[disabled]');

    }

    public function testChangeGroupNameAdmin(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Change group name');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->seeElement('.btn-outline-primary');
        $I->click('Edit');

        $I->see('EDIT GROUP');
        $I->fillField('group_name', "New group name");
        $I->click('Save changes');

        $I->see('GROUPS');
        $I->dontSee('Family');
        $I->see('New group name');
    }

    public function testInvalidNewNameChangeGroup(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Change group name fail');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->seeElement('.btn-outline-primary');
        $I->click('Edit');

        $I->see('EDIT GROUP');
        $I->fillField('group_name', "");
        $I->click('Save changes');

        $I->see('EDIT GROUP');
    }

    public function testRemoveFromGroupMember(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Remove later');
        $I->fillField("#member", "bodin");
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Family');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Ana");
        $I->see('Login');
        $I->fillField('login_username', 'ana');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click('Info');
        $I->see("2 members");
        $I->see("Ana");
        $I->see("Bodin");

        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->seeElement('.btn-outline-primary');
        $I->click('Edit');

        $I->see('EDIT GROUP');
        $I->see('Remove');
        $I->click('Remove');
        $I->see("Are you sure you want to remove this member?");
        $I->click("Yes");
        $I->click('Save changes');

        $I->see('GROUPS');
        $I->amOnPage('/group/index');

        $I->click('Info');
        $I->see("1 members");
        $I->see("Ana");
    }

    public function testLeaveGroupLastMember(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'One member');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click('Info');
        $I->see("1 members");
        $I->see("Ana");

        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->seeElement('.btn-outline-danger');
        $I->click('Leave');

        $I->see("Are you sure you want to leave?");
        $I->click("Yes");
        $I->see("GROUPS");
        $I->dontSee("Family");

    }

    public function testLeaveGroupLeftMembers(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Description');
        $I->fillField("#member", "bodin");
        $I->click('Add');
        $I->see('@bodin');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Family');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->see('GROUPS');
        $I->see('Family');
        $I->seeElement('.btn-outline-danger');
        $I->click('Leave');

        $I->see("Are you sure you want to leave?");
        $I->click("Yes");
        $I->see("GROUPS");
        $I->dontSee("Family");

        $I->amGoingTo("Logout");
        $I->amOnPage('/group/index');
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Ana");
        $I->see('Login');
        $I->fillField('login_username', 'ana');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click('Info');
        $I->see("1 members");
        $I->see("Ana");

    }

    public function testAddNewMemberGroupExists(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Description');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click("Edit");
        $I->see("EDIT GROUP");
        $I->fillField("#invite_member", "bodin");
        $I->click('Invite');
        $I->see('Do you want to send invite?');

        $I->click('OK');
        $I->see('Invite sent');
        $I->click('Save changes');
        $I->amOnPage('/group/index');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Family');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Ana");
        $I->see('Login');
        $I->fillField('login_username', 'ana');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click('Info');
        $I->see("2 members");
        $I->see("Ana");
        $I->see("Bodin");

    }

    public function testAddNewMemberTwice(AcceptanceTester $I)
    {
        $I->dontSee('Family');
        $I->click('Create new');

        $I->amOnPage('/group/renderNewGroup');
        $I->see('NEW GROUP');
        $I->fillField('group_name', 'Family');
        $I->fillField('description', 'Description');
        $I->click('Create Group');

        $I->amOnPage('/group/index');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click("Edit");
        $I->see("EDIT GROUP");
        $I->fillField("#invite_member", "bodin");
        $I->click('Invite');
        $I->see('Do you want to send invite?');
        $I->click('OK');
        $I->see('Invite sent');
        $I->click('Save changes');

        $I->amOnPage('/group/index');
        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Bodin");
        $I->amOnPage('/');
        $I->see('Login');
        $I->fillField('login_username', 'bodin');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/notification/index"]');

        $I->amOnPage('/notification/index');
        $I->see('NOTIFICATIONS');
        $I->see('Family');
        $I->see('Approve');
        $I->click('Approve');
        $I->dontSee('Approve');

        $I->amGoingTo("Logout");
        $I->click('Logout');
        $I->amOnPage('/login/logout');
        $I->see('Login');

        $I->amGoingTo("Login as Ana");
        $I->see('Login');
        $I->fillField('login_username', 'ana');
        $I->fillField('login_password', '123456');
        $I->click('input[type="submit"]');

        $I->amOnPage('/homePage/index');
        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->see('GROUPS');
        $I->see('Family');

        $I->click('Info');
        $I->see("2 members");
        $I->see("Ana");
        $I->see("Bodin");

        $I->click('a[href="http://localhost:8080/group/index"]');
        $I->click("Edit");
        $I->see("EDIT GROUP");
        $I->fillField("#invite_member", "bodin");
        $I->click("Invite");
        $I->see('Do you want to send invite?');
        $I->click('OK');
        $I->see('This user is already a member');

    }
}



