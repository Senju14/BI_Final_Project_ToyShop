<div class="flex flex-col items-center justify-center min-h-screen bg-background p-4">
  <div class="bg-card rounded-lg shadow-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-foreground mb-6">Sign up</h2>
    <form>
      <div class="mb-4">
        <label class="block text-muted-foreground mb-1" for="name">Your Name</label>
        <input class="border border-border rounded-lg p-2 w-full" type="text" id="name" required placeholder="Your Name" />
      </div>
      <div class="mb-4">
        <label class="block text-muted-foreground mb-1" for="email">Your Email</label>
        <input class="border border-border rounded-lg p-2 w-full" type="email" id="email" required placeholder="Your Email" />
      </div>
      <div class="mb-4">
        <label class="block text-muted-foreground mb-1" for="password">Password</label>
        <input class="border border-border rounded-lg p-2 w-full" type="password" id="password" required placeholder="Password" />
      </div>
      <div class="mb-4">
        <label class="block text-muted-foreground mb-1" for="confirm-password">Repeat your password</label>
        <input class="border border-border rounded-lg p-2 w-full" type="password" id="confirm-password" required placeholder="Repeat your password" />
      </div>
      <div class="flex items-center mb-4">
        <input type="checkbox" id="terms" class="mr-2" required />
        <label for="terms" class="text-muted-foreground">I agree all statements in <a href="#" class="text-primary">Terms of service</a></label>
      </div>
      <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/80 rounded-lg p-2 w-full">Register</button>
    </form>
    <p class="text-muted-foreground mt-4 text-center">I am already a member</p>
  </div>
  <img aria-hidden="true" alt="workspace illustration" src="https://openui.fly.dev/openui/300x300.svg?text=Workspace" class="mt-8" />
</div>