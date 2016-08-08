# Unity test
Here we test that our method exectute a particular set of instructions
The test is focused on the way the algorithm operates

The test:
```
/**
 * @test
 * @group admin-message-service
 */
public function testUpdate()
{
    //generete the AdminMessageService Mock with specific Stud Methods
    $this->generateAdminMessageServiceMock(['handleForm', 'generateResult']);

    //------- create some data --------------------------------------

    // create an empty message
    $message = new AdminMessage();

    // create a mock request
    $requestMock = $this->getMockBuilder(Request::class)
        ->disableOriginalConstructor()
        ->getMock();

    // create a form mock. It will be used by the formFactoryMock as the returned value
    // be carefull here : we want to make all the methods stub (setMethods(array())
    $formMock = $this->getMockBuilder(Form::class)
        ->disableOriginalConstructor()
        ->setMethods(array())
        ->getMock();

    //------- execute our test ---------------------------------------

    // step1 : mock the 'findAll' method and set a particular behavior
    $this->adminMessageRepoMock
        ->expects($this->once())
        ->method('findAll')
        ->willReturn([$message]);

    // step2 : the 'create' method must be called once and return a $form
    $this->adminMessageServiceMock
        ->expects($this->once())
        ->method('handleForm')
        ->with($requestMock, $message)
        ->willReturn($formMock);

    // step3 : the 'generateResult' method must be called once
    $this->adminMessageServiceMock
        ->expects($this->once())
        ->method('generateResult')
        ->with($message, $formMock)
        ->willReturn("result");

    // call the method to test
    $this->adminMessageServiceMock->adminUpdate($requestMock);
}
```

The original method:
```
public function adminUpdate(Request $request)
{
    // step1 : fetch the existing message from database or create a new one
    $messages = $this->adminMessageRepo->findAll();
    if (!is_null($messages) && sizeof($messages) > 0) {
        $message = $messages[0];
    } else
        throw new \Exception("L'objet n'existe pas encore");

    // step2 : handleform
    $form = $this->handleForm($request, $message, false);

    // step3 : generate the final result
    return $this->generateResult($message, $form);
}
```




# Functionnal test
Here, we test that our controller works well
We compare data coming from database direct access and data coming from http get request
The test is focused on the result of the method

The test:
```
public function testAdminGetAction()
{
    //-- prerequisite : we use a 'fixture class' to populate the database beforehand

    //-- step1 : fetch data from database
    $adminMessage = $this->em->getRepository('PortalBundle:AdminMessage')->findAll()[0];

    //-- step2 : launch a request
    $this->client->request(
        'GET',
        "portal/admin-message/admin",
        [],
        [],
        $this->headers
    );
    $response = json_decode($this->client->getResponse()->getContent(), true);

    //-- step3 : we expect that the object fetched from database equals the one fetched from GET requests
    //-- verty that (step1 = step2)
    $this->assertEquals($adminMessage->getMessage(), $response['message']);
    $this->assertEquals($adminMessage->getDateStart()->format(\DateTime::ISO8601), $response['date_start']);
    $this->assertEquals($adminMessage->getDateEnd()->format(\DateTime::ISO8601), $response['date_end']);
    $this->assertEquals($adminMessage->isEnabled(), $response['enabled']);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
}
```

The original method:
```
public function adminGetAction()
{
    return $this->adminMessageService->adminGet();
}
```
